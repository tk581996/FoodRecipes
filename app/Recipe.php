<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = "recipe";
    protected $primaryKey = "recipe_id";

    // join with recipe master table via many-many relationship via table material
    public function materials_master()
    {
        return $this->belongsToMany('App\MaterialMaster', 'material', 'recipe_id', 'material_master_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'recipe_id');
    }

    public function likes()
    {
        return $this->hasMany('App\Liked', 'recipe_id');
    }

    // join with recipe img table via one-many relationship
    public function recipes_img()
    {
        return $this->hasMany('App\RecipeImg', 'recipe_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
