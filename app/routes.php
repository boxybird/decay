<?php

use Rosebud\DataTransferObjects\Movies\MovieData;
use Rosebud\DataTransferObjects\Movies\MovieDetailsData;

Flight::route('/', function () {
    $movie_id = (int) $_GET['movie_id'] ??= 23389;
    $member_id = (int) $_GET['member_id'] ??= false;

    $db = Flight::db();

    $single_movie = $db->findOneBy(['data.id', '=', $movie_id])['data'] ?? null;
    $single_movie = MovieDetailsData::fromArray($single_movie);

    $movies = array_map(fn($movie) => MovieData::fromArray($movie['data']), $db->findAll());
    $movies = array_filter($movies, fn($movie) => $movie->id !== $single_movie->id);
    $movies = array_filter($movies, fn($movie) => $movie->computed->poster_paths);
    $movies = array_slice($movies, 0, 30);

    $member = array_filter($single_movie->credits->cast, fn($member) => $member->id == $member_id) ?? null;
    $member = $member ? array_values($member)[0] : null;

    $members = array_filter($single_movie->credits->cast, fn($member) => $member->computed->profile_paths);
    $members = array_slice($members, 0, 4);
    $members = array_filter($members, fn($member) => $member->id !== $member_id);

    $has_member_id = (bool) $_GET['member_id'] ??= false;

    Flight::render('index', [
        'single_movie' => $single_movie,
        'movies' => $movies,
        'member' => $member,
        'members' => $members,
        'has_member_id' => $has_member_id,
    ], 'content');

    Flight::render('base');
});