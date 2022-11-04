ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
# P8_ToDoList

test : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) php56local php  vendor/bin/phpunit

lancerApplication : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) -p 8000:8000 php56local php -S 0.0.0.0:8000 -t web/

bin/console : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) php56local php bin/console doctrine:fixtures:load

composer : docker run --rm --interactive --tty --volume $PWD/conf/date.ini:/usr/local/etc/php/conf.d/date.ini  --volume $PWD:/usr/src/myapp -w /usr/src/myapp --user $(id -u):$(id -g) php56local php composer.phar require symfony/http-client