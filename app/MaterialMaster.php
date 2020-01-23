<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialMaster extends Model
{
    protected $table = "material_master";
    protected $primaryKey = "material_master_id";

    public function recipes(){
        return $this->belongsToMany('App/Recipe','material','material_master_id','recipe_id');
    }
}
