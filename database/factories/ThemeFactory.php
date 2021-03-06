<?php

use Faker\Generator as Faker;

$factory->define(App\Theme::class, function (Faker $faker) {
    return [
    	'company_id' => \App\Company::all()->random()->id,
    	'category_id' => \DB::table('categories')->get()->random()->id,
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'excerpt' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true),
        'body' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        'cover' => 'https://picsum.photos/800/400/?image=' . $faker->numberBetween($min = 100, $max = 400),
        'duration' => $faker->numberBetween($min = 6, $max = 1000),
    ];
});
