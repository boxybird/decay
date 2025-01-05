<?php

Flight::register('movieStore', App\Movie::class);
Flight::register('personStore', App\Person::class);

Flight::set('flight.views.path', __DIR__.'/../views');