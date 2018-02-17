<?php

$url = getenv('CLEARDB_DATABASE_URL');
$url = 'mysql://b091b5494a6413:9b763d86@eu-cdbr-west-02.cleardb.net/heroku_eb14d0b615aa99b?reconnect=true';
$db = parse_url($url);

$container->setParameter('database_driver', 'pdo_mysql');
$container->setParameter('database_host', $db['host']);
$container->setParameter('database_port', 3306 ); // $db['port'] not works with ClearDB
$container->setParameter('database_name', substr($db["path"], 1));
$container->setParameter('database_user', $db['user']);
$container->setParameter('database_password', $db['pass']);
$container->setParameter('secret', getenv('SECRET'));
$container->setParameter('locale', 'en');
$container->setParameter('mailer_transport', null);
$container->setParameter('mailer_host', null);
$container->setParameter('mailer_user', null);
$container->setParameter('mailer_password', null);

?>

