<?php

test('homepage can be rendered', function () {
    $response = $this->get('https://decay.test');

    expect($response)
        ->toContain('<title>Decay</title>');
});
