<?php

require __DIR__.'/../app/Database.php';

Flight::register('db', Database::class);

Flight::set('flight.views.path', __DIR__.'/../views');