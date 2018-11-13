# ThyArt API

a PHP Laravel API working with the ThyArt Web Project.

## clone
```
git clone https://git-codecommit.eu-west-1.amazonaws.com/v1/repos/thyart-api --recurse-submodules
```

## Makefile
this project is built with a **Makefile**. Here is the **available commands**:
```
make all       -> install environment files, initiate laradock container install composer dependencies and generate project keys
make database  -> run migrations on development and testing database, install passport and run seeders for the tests
make clean     -> remove containers and environment files
make fclean    -> execute clean and delete laradock mysql files and delete laradock images. (WARNING: it is very dangerous on using it when you have more than one project using Laradock)
make start     -> start all containers
make stop      -> stop all containers
make re        -> run fclean and all
make tests     -> run unit tests
make workspace -> going into workspace container to work with php
```