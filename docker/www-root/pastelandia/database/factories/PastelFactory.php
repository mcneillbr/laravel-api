<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pastel;
use Faker\Generator as Faker;

$factory->define(Pastel::class, function (Faker $faker) {
    $createImage = (function($data, $type = 'png') {
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    });
    return [
        'nome' => $faker->name,
        'preco' => $faker->randomFloat(2, 2, 10),
        'foto' => $createImage($faker->text)
    ];
});
