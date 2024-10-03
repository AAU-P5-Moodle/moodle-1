
Setup Guide

Prerequisites
1. Ensure Docker Desktop is installed on your system.
    - You can download it from here: https://www.docker.com/products/docker-desktop.
2. After installation, make sure Docker Desktop is running correctly.

Setup Instructions

1. Adjust the docker-compose.yml (if applicable):
    - If you're not using an ARM architecture, update the image in the docker-compose.yml file accordingly.
    - If you're using an ARM architecture, skip this step.

2. Start the Docker container:
    - Open a terminal and navigate to the directory where the docker-compose.yml file is located.
    - Run the following command:
      docker-compose up

3. Access the application:
    - Once the container is running, open your browser and go to:  
      http://localhost/index.php
    - Log in using the following credentials:
      Username: admin
      Password: Admin.123

4. Updating the LiveQuiz:
    - You can now modify the LiveQuiz directly, and the changes will be reflected on the website without needing an import.
