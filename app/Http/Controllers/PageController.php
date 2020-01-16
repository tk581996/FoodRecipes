<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialMaster;

class PageController extends Controller
{
    public function getIndex(){
        return view('page.home');
    }

    public function getLogin(){
        return view('page.login');
    }

    public function getRegister(){
        return view('page.register');
    }

    public function getItemDetail(){
        return view('page.itemdetail');
    }

    public function getInputForm(){
        $material_master = MaterialMaster::all();
        return view('page.input-form', compact('material_master'));
    }   
}