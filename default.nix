{ pkgs ? import <nixpkgs> {} }:

let
  mariadb_data_dir = "./mariadb_data";
  mariadb_socket = "/tmp/mysqld.sock";
  adminer_port = 8080;
  moodle_db_name = "moodle";
  moodle_sql_file = "./MoodleSQL.sql";
  root_password = "root";
  php_custom_config = "./custom_php.ini";

in

pkgs.mkShell {
  buildInputs = with pkgs; [
    mariadb
    php
    wget
    curl
    procps
    lsof
    php82Packages.composer
    glibcLocales
  ];

  shellHook = ''
    MOODLE_ROOT="$(realpath server/moodle)"
    export LANG="en_AU.UTF-8" #Why does it need to be Australian? Nobody knows...
    export LC_ALL="en_AU.UTF-8"
    # export PHPRC=`realpath server/php/php.ini`


    # Function to check and kill existing processes
    kill_existing() {
      local process=$1
      if pgrep -x "$process" > /dev/null; then
        echo "Killing existing $process process..."
        pkill -x "$process"
        sleep 2
      fi
    }

    # Function to kill process using a specific port
    kill_port_user() {
      local port=$1
      local pid=$(lsof -ti:$port)
      if [ ! -z "$pid" ]; then
        echo "Killing process using port $port..."
        kill -9 $pid
        sleep 2
      fi
    }

    # Ensure MariaDB data directory exists
    mkdir -p ${mariadb_data_dir}

    # Initialize MariaDB if not already done
    if [ ! -d "${mariadb_data_dir}/mysql" ]; then
      mysql_install_db --datadir=${mariadb_data_dir}
      # Start MariaDB temporarily to set up the database
      mysqld --datadir=${mariadb_data_dir} --socket=${mariadb_socket} --skip-grant-tables &
      TEMP_MYSQL_PID=$!
      while [ ! -S ${mariadb_socket} ];
      do
        echo "no socket file. Waiting 1 secs and trying again";
        sleep 1
      done
      echo "MariaDB is up continuing.";

      # Set root password and authentication method
      echo "Setting root password..."
      mysql -uroot -S${mariadb_socket} <<EOF
      FLUSH PRIVILEGES;
      ALTER USER 'root'@'localhost' IDENTIFIED BY '${root_password}';
      FLUSH PRIVILEGES;
EOF

      # Verify root password
      echo "Verifying root password..."
      mysql -uroot -p${root_password} -S${mariadb_socket} -e "SELECT 1;" || {
        echo "Error: Root password verification failed."
        kill $TEMP_MYSQL_PID
        wait $TEMP_MYSQL_PID
        exit 1
      }

      mysql -uroot -p${root_password} -S${mariadb_socket} -e "CREATE DATABASE IF NOT EXISTS ${moodle_db_name}" || {
        echo "Error: Failed to create database ${moodle_db_name}."
        kill $TEMP_MYSQL_PID
        wait $TEMP_MYSQL_PID
        exit 1
      }

      if [ -f "${moodle_sql_file}" ]; then
        mysql -uroot -p${root_password} -S${mariadb_socket} ${moodle_db_name} < ${moodle_sql_file} && {
          echo "SQL file imported successfully."
        } || {
          echo "Error: Failed to import SQL file."
        }
      else
        echo "Warning: ${moodle_sql_file} not found. Database created but not populated."
      fi

      kill $TEMP_MYSQL_PID
      wait $TEMP_MYSQL_PID
    fi

    # Kill existing MariaDB and PHP processes
    kill_existing "mysqld"
    kill_existing "php"
    # kill_port_user ${toString adminer_port}

    # Start MariaDB
    start_mariadb() {
      echo "Starting MariaDB..."
      mysqld --datadir=${mariadb_data_dir} --socket=${mariadb_socket} &
      MARIADB_PID=$!
      while [ ! -S ${mariadb_socket} ];
      do
        echo "no socket file. Waiting 1 secs and trying again";
        sleep 1
      done
      echo "MariaDB is up continuing.";
    }

    # Start Adminer
    start_adminer() {
      echo "Starting Adminer on port ${toString adminer_port}..."
      if [ ! -f "adminer.php" ]; then
        echo "Downloading Adminer..."
        wget https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1.php -O adminer.php
      fi
      if [ -f "adminer.php" ]; then
        echo "Starting Adminer..."
        echo "<?php
        // Always serve adminer.php regardless of the request URI
        require 'adminer.php';
        ?>" > adminer_router.php
        php -S 0.0.0.0:${toString adminer_port} adminer_router.php &
        ADMINER_PID=$!
      else
        echo "Error: Failed to download Adminer. Using a minimal PHP script instead."
        echo "<?php
        echo '<h1>Adminer Not Found</h1>';
        echo '<p>Failed to download Adminer. Here are some debug details:</p>';
        echo '<h2>PHP Info:</h2>';
        phpinfo();
        ?>" > adminer_fallback.php
        php -S 0.0.0.0:${toString adminer_port} adminer_fallback.php &
        ADMINER_PID=$!
      fi
    }
    create_php_config() {
      get_certificate
      echo "Creating custom PHP configuration..."
      cat << EOF > ${php_custom_config}
extension=zip
extension=gd
extension=intl
extension=fileinfo
extension=sodium
extension=mysqli
max_input_vars = 5000
memory_limit = 256M
post_max_size = 50M
upload_max_filesize = 50M

EOF
    }
    get_certificate(){
      curl --etag-compare etag.txt --etag-save etag.txt --remote-name https://curl.se/ca/cacert.pem -o "cacert.pem"
    }
    # Start PHP built-in server for Moodle
    start_php_server() {
      create_php_config
      echo "Starting PHP built-in server for Moodle..."
      php -S 0.0.0.0:8000 -t ./server/moodle -c ${php_custom_config} &
      PHP_SERVER_PID=$!
    }

    # Function to stop services
    stop_services() {
      echo "Stopping services..."
      kill $MARIADB_PID $ADMINER_PID $PHP_SERVER_PID 2>/dev/null
      rm -f ${mariadb_socket}
      rm -f ./adminer_router.php
    }
    
    check_phpunit() {
      if [ ! -d "$MOODLE_ROOT/vendor" ]; then
      echo "no phpunit installed installing it now"
      install_phpunit
      fi
      if [ ! -d "$MOODLE_ROOT/vendor" ]; then
      echo "installing failed exiting"
      exit 1
      fi
      echo "phpunit found"
    }
    install_phpunit() {
      CURRENT_PATH="$(pwd)"
      cd "$MOODLE_ROOT"
      composer require --dev phpunit/phpunit
      echo "success installing phpunit"
      cd "$CURRENT_PATH"
    }
    runit(){
      check_phpunit

      php server/moodle/admin/cli/install.php \
              --lang=en \
              --wwwroot="http://localhost:8000/" \
              --dataroot="server/moodledata" \
              --dbpass=root \
              --dbport=3306 \
              --dbsocket="$mariadb_socket" \
              --skip-database \
              --non-interactive \
              --agree-license \
              --allow-unstable \
              --fullname="Moodle testing thing" \
              --shortname="mtt" \
              --adminpass="hunter2"
          echo "\$CFG->phpunit_prefix = 'phpu_';" >>"server/moodle/config.php"
          echo "\$CFG->phpunit_dataroot = '$(realpath "server/moodledata/phpunit")';">>"server/moodle/config.php"
      php server/moodle/admin/tool/phpunit/cli/init.php
      CURRENT_PATH="$(pwd)"
      cd "$MOODLE_ROOT"
      for file in `find mod/livequiz/tests/phpunit -type f`
      do
        echo Running tests in $file
        vendor/bin/phpunit --verbose $file
      done
      cd "$CURRENT_PATH"
    }
    
    # Trap to ensure services are stopped when exiting the shell
    trap stop_services EXIT

    # Start services
    start_mariadb
    start_adminer
    start_php_server





    echo "MariaDB, Adminer, and PHP server are now running."
    echo "Adminer is available at http://localhost:${toString adminer_port}"
    echo "Moodle is available at http://localhost:8000"
    echo "To connect to MariaDB, use:"
    echo " Host: 127.0.0.1 or localhost"
    echo " Username: root"
    echo " Password: ${root_password}"
    echo " Database: ${moodle_db_name}"
    echo "Press Ctrl+C to stop the services and exit."
  '';
}
