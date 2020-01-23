<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MaterialMaster;
use App\Material;
use App\Recipe;
use App\RecipeImg;

class PageController extends Controller
{
    public function getIndex()
    {
        $recipe = Recipe::where('is_deleted', 0)->paginate(2);
        $recipe->withPath('/index');
        // dd($recipe);
        return view('page.home', compact('recipe'));
    }

    public function getLogin()
    {
        return view('page.login');
    }

    public function getRegister()
    {
        return view('page.register');
    }

    public function getItemDetail(Request $request)
    {
        //2 cach get recipe co id = id nhap tren thanh url
        //get recipe info where id = $request
        $recipe = Recipe::where('recipe_id', $request->id)->first();
        //get img_url from recipe model where id = $request
        $recipe_imgs = Recipe::find($request->id)->recipes_img()->get();
        //get recipe_material from recipe model where id = $request
        $recipe_material = Recipe::find($request->id)->materials_master()->get();
        // get user who created recipe for getting info
        $recipe_user = Recipe::find($request->id)->user()->first();
        return view('page.itemdetail', compact('recipe_material', 'recipe', 'recipe_imgs', 'recipe_user'));
    }

    public function getInputForm()
    {
        $material_master = MaterialMaster::all();
        return view('page.input-form', compact('material_master'));
    }
}
