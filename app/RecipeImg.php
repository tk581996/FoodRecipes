<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeImg extends Model
{
    protected $table = "recipe_img";
    protected $primaryKey = "recipe_id"; //recipe_img table have no primarykey, get img only with recipe id

    public function recipe()
    {
        return $this->belongsTo('App\Recipe', 'recipe_id');
    }
}
