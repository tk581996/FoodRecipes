<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\MaterialMaster;
use App\Material;
use App\Recipe;
use App\RecipeImg;
use App\Comment;
use App\User;

class PageController extends Controller
{
    public function getIndex()
    {
        $recipes = Recipe::where('is_deleted', 0)->paginate(9);
        return view('page.home', compact('recipes'));
    }

    public function getLogin(Request $request)
    {
        return view('page.login');
    }

    public function postLogin(Request $request)
    {
        $arr = [
            'login_id' => $request->loginid,
            'password' => $request->password
        ];

        if (Auth::attempt($arr)) {
            return back();
        } else {
            dd($arr);
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->back();
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
        // dd($test); 
        // get user who created recipe for getting info
        $recipe_user = Recipe::find($request->id)->user()->first();
        return view('page.itemdetail', compact('recipe_material', 'recipe', 'recipe_imgs', 'recipe_user'));
    }

    public function postComment($id, Request $request)
    {
        $comment = new Comment;
        $comment->user_id = Auth::user()->user_id;
        $comment->recipe_id = $id;
        $comment->content = $request->content;
        $comment->save();

        return back();
    }

    public function getInputForm()
    {
        $material_master = MaterialMaster::all();
        return view('page.input-form', compact('material_master'));
    }
}
