<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingredient;
use Astrotomic\Translatable\Translatable;
class Meal extends Model 
{
    use Translatable;

    protected $fillable = ['title', 'description', 'status','ingredients','category','tags'];
    public $translatedAttributes = ['title_tr','description_tr'];
    protected $hidden = ['created_at', 'updated_at', 'pivot', 'translations','title_tr','category_id','description_tr'];
    public $ingredients = Ingredient::class;
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'ingredients_meal')->withPivot('id');;
    }

    public function tags()
    {
        return $this->belongsToMany(tags::class, 'tags_meal')->withPivot('id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Rest of your model logic
}

