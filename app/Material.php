<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = "material";

    public function recipe()
    {
        return $this->belongsTo('App\Recipe');
    }
    public function material_master()
    {
        return $this->belongsTo('App\MaterialMaster');
    }
}
