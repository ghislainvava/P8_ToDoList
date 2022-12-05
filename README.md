ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
# P8_ToDoList



***

A list of technologies used within the project:
* PHP(https://www.php.net)Version8.1.10
* Symfony(https://symfony.com)Version6.1
* Composer(https://getcomposer.org)Version2.4.2
* Doctrine-bundle (https://symfony.com/doc/2.7/doctrine.html)Version2.7
* phpunit(https://phpunit.readthedocs.io/en/9.5/)Version9.5



## installation guide

```shell
$ git clone https://github.com/ghislainvava/P8_ToDoList.git
$ composer install
$ create an `.env.local` (from `.env`) file and write the necessary information to the database
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:fixtures:load
$ php -S 127.0.0.1:8000 -t public public/index.php
```
	