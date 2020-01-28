<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = "material";
    protected $primaryKey = "recipe_id";
    protected $fillable = ['material_master_id'];

    public function recipe()
    {
        return $this->belongsTo('App\Recipe');
    }
    public function material_master()
    {
        return $this->belongsTo('App\MaterialMaster');
    }
}
