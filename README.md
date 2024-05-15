# docker-exali-test

This project is a test docker stack for a REST API

It is a small Symfony framework according to the requirements with PHPUnitTests and PHPStan for code quality

After getting the repo from GIT, change into the project directory and follow the instruction.

## docker compose

The simplest way to build/start the container is by running:

```console
jdoe@host:/home/jdoe/projects/exali-test $ docker compose up --build
```
This will install the framework, composer and the SymfonyCLI.
To install the vendors hook into the running app-container with
```console
jdoe@host:/home/jdoe/projects/exali-test $ docker compose exec app bash
```
and run the command
```console
root@cd5d6b27a5a3:/var/www/app# composer install
```
Now you are good to go. 

For your convenience I added a few aliases to the app-container (defined in the Dockerfile)
