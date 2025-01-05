<?php

use Rosebud\DataTransferObjects\Movies\MovieData;
use Rosebud\DataTransferObjects\Movies\MovieDetailsData;
use Rosebud\DataTransferObjects\People\PersonDetailsData;

Flight::route('/', function () {
    $movie_id = (int) Flight::request()->query->movie_id ??= 23389;
    $member_id = (int) Flight::request()->query->member_id ??= false;
    $has_member_id = (bool) $member_id ??= false;

    $db_movie = Flight::movieStore();
    $db_person = Flight::personStore();

    $movie_single = $db_movie->findOneBy(['data.id', '=', $movie_id])['data'] ?? null;

    if (!$movie_single) {
        return Flight::response()->status(404);
    }

    $movie_single = MovieDetailsData::fromArray($movie_single);

    $movies = array_map(fn($movie) => MovieData::fromArray($movie['data']), $db_movie->findAll());
    $movies = array_filter($movies, fn($movie) => $movie->id !== $movie_single->id);
    $movies = array_filter($movies, fn($movie) => $movie->computed->poster_paths);

    $member = array_filter($movie_single->credits->cast, fn($member) => $member->id == $member_id) ?? null;
    $member = $member ? array_values($member)[0] : null;

    $member_single = $member ? $db_person->findOneBy(['id', '=', $member->id]) : null;
    $member_single = $member_single ? PersonDetailsData::fromArray($member_single) : null;

    $members = array_filter($movie_single->credits->cast, fn($member) => $member->computed->profile_paths);
    $members = array_slice($members, 0, 4);
    $members = array_filter($members, fn($member) => $member->id !== $member_id);

    $details = [];
    $details['type'] = $member?->id ? 'member' : 'movie';
    $details['featured_image'] = $member?->id ? $member->computed->profile_paths['w500'] : $movie_single->computed->poster_paths['w500'];
    $details['featured_image_alt'] = $member?->id ? "{$member_single?->name} image" : "{$movie_single->title} poster";
    $details['description'] = $member?->id ? $member_single->biography ?? null : $movie_single->overview;

    Flight::render('index', [
        'movie_single' => $movie_single,
        'movies' => $movies,
        'member' => $member,
        'member_single' => $member_single,
        'members' => $members,
        'has_member_id' => $has_member_id,
        'details' => $details,
    ], 'content');

    Flight::render('base');
});
