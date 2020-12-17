# Setting up the project

This project has two folders, the frontend and the backend.
To run execute following commands in different terminals. 
    - Frontend:
        - cd frontend
        - (npm install)
        - npm run dev

    - Backend:
        - cd backend/src
        - (composer install)
        - php -S localhost:8080 -t public

The database is already within the project (backend/src/db/db.sqlite).

# How to operate

In the project there are 3 different of roles
    - Non logged in user
    - Logged in user
    - Logged in admin/arch

to login simply go to the login and use one of the following test accounts
    - Student:
        - email: student@student.com
        - password: student

    - Arch: 
        - email: arch@arch.com
        - password: arch


# How to cron jobs

Currently there is a route available to send a cron request to with curl.
To use this download Curl and simply use the command `curl localhost:8080/executeCronJob`



[The Cost](https://drive.google.com/file/d/1TNnQUV4BPr9SxDi6lm-N7XDkNYLBM9Wo/view?usp=sharing)

[The Powerpoint](https://drive.google.com/file/d/1AJmosbs3zWZieSw7dvdKxrA4G8klOKUO/view?usp=sharing)