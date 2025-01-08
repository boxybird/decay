<?php

use Rosebud\DataTransferObjects\Movies\MovieData;
use Rosebud\DataTransferObjects\Movies\MovieDetailsData;
use Rosebud\DataTransferObjects\People\PersonDetailsData;

Flight::route('/', function () {
    $movie_single_id = (int) Flight::request()->query->movie_id ??= 23389;
    $member_id = (int) Flight::request()->query->member_id ??= 0;
    $has_member_id = (bool) $member_id ??= false;
    $showing_trailer = (bool) Flight::request()->query->showing_trailer ??= false;

    $db_movie = Flight::movieStore();
    $db_person = Flight::personStore();

    $movie_single = $db_movie->findOneBy(['data.id', '=', $movie_single_id])['data'] ?? null;

    if (!$movie_single) {
        return Flight::response()->status(404);
    }

    $movie_single = MovieDetailsData::fromArray($movie_single);
    $movie_single_video = array_filter($movie_single->videos->results, fn($video): bool => $video->site === 'YouTube')[0] ?? null;
    $movie_single_video = $movie_single_video ? "https://www.youtube.com/embed/{$movie_single_video->key}" : null;

    $movies = array_map(fn($movie): MovieData => MovieData::fromArray($movie['data']), $db_movie->findAll(orderBy: ['id' => 'desc'], limit: 30));
    $movies = array_filter($movies, fn($movie): array => $movie->computed->poster_paths);

    $member = array_filter($movie_single->credits->cast, fn($member): bool => $member->id === $member_id) ?? null;
    $member = !empty($member) ? array_values($member)[0] : null;

    $member_single = $member ? $db_person->findOneBy(['id', '=', $member->id]) : null;
    $member_single = $member_single ? PersonDetailsData::fromArray($member_single) : null;

    $members = array_filter($movie_single->credits->cast, fn($member): array => $member->computed->profile_paths);
    $members = array_slice($members, 0, 4);
    $members = array_filter($members, fn($member): bool => $member->id !== $member_id);

    $details = [];
    $details['type'] = $member?->id ? 'member' : 'movie';
    $details['featured_image'] = $member?->id ? $member->computed->profile_paths['w500'] : $movie_single->computed->poster_paths['w500'];
    $details['featured_image_alt'] = $member?->id ? "{$member_single?->name} image" : "{$movie_single->title} poster";
    $details['description'] = $member?->id ? $member_single->biography ?? null : $movie_single->overview;

    Flight::render('index', [
        'movie_single_id' => $movie_single_id,
        'movie_single' => $movie_single,
        'movie_single_video' => $movie_single_video,
        'movies' => $movies,
        'member' => $member,
        'member_single' => $member_single,
        'members' => $members,
        'has_member_id' => $has_member_id,
        'showing_trailer' => $showing_trailer,
        'details' => $details,
    ], 'content');

    Flight::render('base');
});
