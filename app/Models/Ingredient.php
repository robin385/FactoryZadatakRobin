<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;   
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model {
    use HasFactory;
    use Translatable;
    public $fillable = ['title', 'slug'];
    public $translatedAttributes = ['title_tr'];
    protected $hidden = ['created_at', 'updated_at', 'pivot', 'translations','title_tr'];
    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'ingredients_meal')->withPivot('id');
    }

}
