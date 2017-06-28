ECHO "Initializing project"
php composer.phar install

ECHO "Starting server"
php bin/console server:run
