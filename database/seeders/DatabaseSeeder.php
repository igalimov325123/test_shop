<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Database\Factories\ProductCategoriesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Category::factory(10)->create();
         Product::factory(10)->create()->each(function ($product) {
             $categories = Category::find(rand(1, Category::count()-1));
             $product->categories()->save($categories);
         });
    }

}
