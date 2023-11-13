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
use Illuminate\Support\Carbon;
class ApiController extends Controller
{

    /*
    the getJsonResponse function is used to get the data from the database
    we have 5 parameters that we can use to filter the data
    per_page - number of items per page
    tags - filter by tags
    lang - filter by language
    with - filter by relations
    page - page number
    diff_time - unix timestamp
    */
    
    public function getJsonResponse(Request $request)
    {
        $per_page = (int)$request->input('per_page', 5);
        $tags = $request->input('tags', null);
        $lang = $request->input('lang', 'hr'); // Default to 'hr' if not provided
        $with =  $request->input('with', 'ingredients,tags,category');
        $page = (int)   $request->input('page', 1);
        $difftime= $request->input('diff_time', 0);
        if($difftime!==0)
        {


            $timestampParameter = $request->input('time', '');

            // Parse the timestamp from the URL
            $timestamp = intval($timestampParameter);

            // Convert Unix timestamp to a Carbon instance
            $dateTime = Carbon::createFromTimestamp($timestamp);
            $now = Carbon::now();

            // Calculate the difference in seconds
            $diffInSeconds = $dateTime->diffInSeconds($now);
            
        
        }
        App::setLocale($lang);
        // Calculate the values based on the provided parameters
        $totalItems = $per_page * $page;
    

        $data = [];
        $data['target'] = [
            "current page" => $page,
            "total items" => $totalItems,
            "itemsPerPage" => $per_page,
            "lang" => $lang,
            "with" => $with,
            "tags" => $tags,
            
        ];
    
        $data['data'] = []; // Array to store the meals
 

        
        
        $wth = explode(',', $with);

        //filter meals by the specified tags
        if($tags!==null)
        {
            $meals= Meal::with( $wth)->whereHas('tags', function ($query) use ($tags) {
                $query->where('tags_id', $tags);
            })->take($per_page)->get();
        }
        else
        $meals= Meal::skip($page*$per_page)->with( $wth)->take($per_page)->get();

        $data['data'] = $meals;
        //previous url
        $previous = URL::previous();
        //current url
        $current = URL::current();
        
        $data['links'] = [
            "self" => $current,
            "previous" => $previous,
            "next" => $current.'?page='.($page+1),
        ];	
        return response()->json($data);
    }

    
    
}

