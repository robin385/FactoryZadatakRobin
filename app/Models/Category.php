<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Category extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected  $fillable = ['title', 'slug'];
    public $translatedAttributes = ['title_tr'];
    protected $hidden = ['created_at', 'updated_at', 'pivot', 'translations','title_tr'];
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}
