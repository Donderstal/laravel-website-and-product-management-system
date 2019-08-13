<?php

use App\Models\ProductsColors;
use App\Models\ProductsBrands;
use App\Models\ProductsGallery;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Models\Products::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'price' => 100000,
        'mileage' => 100000,
        'year' => $faker->year(),
        'fuel' => 'diesel',
        'transmission' => 'at',
        'color_id' => function() {
            return ProductsColors::first()->id;
        },
        'brand_id' => function() {
            $brand = ProductsBrands::first();
            return $brand->id;
        },
        'model_id' => function(array $product) {
            $brand = ProductsBrands::find($product['brand_id']);
            return $brand->models->first()->id;
        },
        'status' => 'coming_soon',
        'enable' => 1,
        'created_by' => function () {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});

$factory->afterCreating(App\Models\Products::class, function ($product, $faker) {
    $dir = '/tmp';
    $width = 640;
    $height = 480;
    $random_image = $faker->image($dir, $width, $height, 'transport');
    $fake_uploaded_file = new \Illuminate\Http\UploadedFile($random_image, $faker->name());
    $product->setCover($fake_uploaded_file);
});