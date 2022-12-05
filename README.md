ToDoList
========

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1da370de0639461f99a6435da264a429)](https://app.codacy.com/gh/ghislainvava/P8_ToDoList?utm_source=github.com&utm_medium=referral&utm_content=ghislainvava/P8_ToDoList&utm_campaign=Badge_Grade_Settings)

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
# P8_ToDoList

test : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) php56local php  vendor/bin/phpunit

lancerApplication : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) -p 8000:8000 php56local php -S 0.0.0.0:8000 -t web/

bin/console : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) php56local php bin/console doctrine:fixtures:load

composer : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) php56local php composer.phar require symfony/http-client

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
	