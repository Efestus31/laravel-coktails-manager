<?php

namespace Database\Seeders;

use App\Models\Cocktail;
use App\Models\Ingredient;
use App\Models\Type;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CocktailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        // Seed Types
        if (Type::count() === 0) {
            Type::create(['name' => 'Aperitif']);
            Type::create(['name' => 'Long Drink']);
            Type::create(['name' => 'After Dinner']);
            Type::create(['name' => 'Shots']);
            Type::create(['name' => 'Digestif']);
            Type::create(['name' => 'Mocktail']);
            Type::create(['name' => 'Tiki']);
        }

        // Seed Ingredients
        if (Ingredient::count() === 0) {
            Ingredient::create(['name' => 'Vodka']);
            Ingredient::create(['name' => 'Gin']);
            Ingredient::create(['name' => 'Rum']);
            Ingredient::create(['name' => 'Lime Juice']);
            Ingredient::create(['name' => 'Sugar Syrup']);
            Ingredient::create(['name' => 'Mint Leaves']);
            Ingredient::create(['name' => 'Triple Sec']);
            Ingredient::create(['name' => 'Tequila']);
            Ingredient::create(['name' => 'Whiskey']);
            Ingredient::create(['name' => 'Campari']);
            Ingredient::create(['name' => 'Vermouth Rosso']);
            Ingredient::create(['name' => 'Orange Juice']);
            Ingredient::create(['name' => 'Soda Water']);
            Ingredient::create(['name' => 'Angostura Bitters']);
        }

        $typeIds = Type::pluck('id')->toArray();
        $ingredientIds = Ingredient::pluck('id')->toArray();

        //  sample images in database/seeders/sample-images
        $images = [
            'cocktail1.jpg',
            'cocktail2.jpg',
            'cocktail3.jpg',
            'cocktail4.jpg',
            'cocktail5.jpg',
            'cocktail6.jpg',
            'cocktail7.jpg',
            'cocktail8.jpg',
            'cocktail9.jpg',
            'cocktail10.jpg',
        ];

        foreach ($images as $filename) {
            // Read binary data from file
            $path = database_path('seeders/sample-images/' . $filename);
            $imageData = file_exists($path) ? file_get_contents($path) : null;

            // Create cocktail with binary image
            $newCocktail = Cocktail::create([
                'name'         => ucfirst($faker->word()) . ' Cocktail',
                'description'  => $faker->sentence(),
                'instructions' => $faker->paragraph(),
                'type_id'      => $faker->randomElement($typeIds),
                'image_data' => $imageData,
            ]);

            // Attach random ingredients
            $newCocktail->ingredients()->attach(
                $faker->randomElements($ingredientIds, rand(2, 4))
            );
        }
    }
}