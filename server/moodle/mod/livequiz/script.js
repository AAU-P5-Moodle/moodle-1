const fs = require('fs');
const path = require('path');
const uglifyJS = require('uglify-js');

/*
* THIS IS A TEMPORARY SCRIPT. A PROPER SOLUTION SHOULD BE IMPLEMENTED WITH GRUNT.
* This script needs to run when you want to see changes from your js. 
*
* */




// folders.
const srcDir = path.join(__dirname, 'amd', 'src');
const buildDir = path.join(__dirname, 'amd', 'build');

// creates build-folder, if it's isn't found.
if (!fs.existsSync(buildDir)) {
  fs.mkdirSync(buildDir);
}

// reads all, js-files form the src-folder.
fs.readdir(srcDir, (err, files) => {
  if (err) {
    console.error("Error reading the src directory:", err);
    return;
  }

  // filters only .js-files
  files.filter(file => file.endsWith('.js')).forEach(file => {
    const srcFilePath = path.join(srcDir, file);
    const buildFilePath = path.join(buildDir, file.replace('.js', '.min.js'));

    // reads the contents of the files
    const code = fs.readFileSync(srcFilePath, 'utf8');

    // Uglify files
    const result = uglifyJS.minify(code);

    if (result.error) {
      console.error(`Error minifying ${file}:`, result.error);
      return;
    }

    // writes an uglified version to the build-folder
    fs.writeFileSync(buildFilePath, result.code, 'utf8');
    console.log(`Successfully uglified: ${file} -> ${buildFilePath}`);
  });
});
