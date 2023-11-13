<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use Faker\Factory as Faker;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Locales;
use App\Models\Meal;
use App\Models\Ingredient;
use App\Models\tags;
use App\Models\Category;
use App\Models\MealTranslation;

class FakeData extends Controller
{

    /*
    the generateFakeData function is used to generate fake data for the database
    we generate multilingual data for the meals,ingredients,tags and categories
    and it is important that we generate the data for the pivot tables
    

    the function is called from the route /api/fake-data
    */
    public function generateFakeData()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {

            $meal = Meal::create([
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'status' => 'created',
                'category_id' => $faker->numberBetween(1, 4),
            ]);
            // Check if a translation for the current locale already exists
            $meal->translateOrNew('en')->title = $faker->sentence(6);
            $meal->translateOrNew('hr')->title = $faker->sentence(6);
            $meal->translateOrNew('en')->description = $faker->sentence(6);
            $meal->translateOrNew('hr')->description = $faker->sentence(6);
            $meal->save();


        }
        $meals = Meal::all();
           //make the request with lang hr and en
           for($i=1;$i<21;$i++)
           {
   
               $tags = new tags();
               $tags->title = $faker->word;
               $tags->slug = $faker->slug;
               $tags->translateOrNew('en')->title = $faker->word;
               $tags->translateOrNew('hr')->title = $faker->word;
               $tags->save();
               $meals[$i]->tags()->attach($tags->id);
               $meals[$i]->save();
               
           
               
           }
        for($i=0;$i<71;$i++)
           {
            //generate some ingredients then add them to specific meal
   
               $ingredient = new Ingredient();
               $ingredient->title = $faker->word;
               $ingredient->slug = $faker->slug;
               $ingredient->translateOrNew('en')->title = $faker->word;
               $ingredient->translateOrNew('hr')->title = $faker->word;
               $ingredient->save();
               $meals[$i]->ingredients()->attach($ingredient->id);
   
   
           }
   
   
           // create  a faker for 70 meals and create the status that is possible created or deleted choose between them randomly
          for($i=0;$i<71;$i++)
           {
               // add to meal attach category
               $meals[$i]->status = $faker->randomElement(['created', 'deleted']);

           }
           
           foreach($meals as $meal)
           {
               // add to meal attach category
               $category = new Category();
               $category->title = $faker->word;
               $category->slug = $faker->slug;
                $category->translateOrNew('en')->title = $faker->word;
                $category->translateOrNew('hr')->title = $faker->word;
                $category->save();
               $meal->category()->associate($category);
               $meal->save();
           }
           $meals=Meal::with('category','tags','ingredients')->get();
           $data['data'][] = $meals;

           return response()->json($data);
   
    }
    //
}
