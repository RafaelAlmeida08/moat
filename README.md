# Courses Platform API

This is a project to Moat PHP test.

## How to use it?
After cloning the project you must open your terminal and run the following commands:

1 - composer install

2 - php bin/console doctrine:database:create

3 - php bin/console doctrine:migrations:migrate

Those commands will download all the dependencies, create the database and migrate the database to the database specified.
We are using the SQLITE database to make it simple.

## Routes
You have to create a user first to access the rest of the routes.

Create a new user: http://127.0.0.1:8000/user/new

Login page: http://127.0.0.1:8000/login

Artists page: http://127.0.0.1:8000/artist

Album page: http://127.0.0.1:8000/album

