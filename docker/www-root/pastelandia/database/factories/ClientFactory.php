<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'telefone' => $faker->randomNumber(2) . $faker->randomNumber(9),
        'data_nascimento' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = '-10 years', $timezone = null),
        'endereco' => $faker->address,
        'complemento' => $faker->locale,
        'bairro' => implode(' ', $faker->words(2)),
        'cep' => $faker->randomNumber(9)
    ];
});
