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
use App\Liked;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PhpMyAdmin\Session;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function getIndex(Request $request)
    {
        if ($request->sort != NULL) {
            switch ($request->sort) {
                case "created_at_desc":
                    $aa = Recipe::where('is_deleted', 0)->orderBy("created_at", "desc");
                    break;
                case "created_at_asc":
                    $aa = Recipe::where('is_deleted', 0)->orderBy("created_at", "asc");
                    break;
                case "like_desc":
                    $aa = Recipe::where('is_deleted', 0)->orderBy("created_at", "desc");
                    break;
            }
            $recipes = $aa->paginate(9)->appends('sort', $request->sort);
        } else {
            $recipes = Recipe::where('is_deleted', 0)->orderBy("created_at", "desc")->paginate(9);
        }
        return view('page.home', compact('recipes'));
    }

    //Search
    public function postSearch(Request $request)
    {
        $search = $request->search;
        $recipe_avai = Recipe::where('is_deleted', 0)->where("title", 'like', "%$search%")->orWhere("food_name", "like", "%$search%")->orWhere("cook_time", "like", "%$search%");
        $recipes = $recipe_avai->orderBy("created_at", "desc")->paginate(9);
        return view('page.search', compact('recipes', 'search'));
    }

    public function getSearch(Request $request)
    {
        $search = $request->search;
        $recipe_avai = Recipe::where('is_deleted', 0)->where("title", 'like', "%$search%")->orWhere("food_name", "like", "%$search%")->orWhere("cook_time", "like", "%$search%");
        if ($request->sort != NULL) {
            switch ($request->sort) {
                case "created_at_desc":
                    $aa = $recipe_avai->orderBy("created_at", "desc");
                    break;
                case "created_at_asc":
                    $aa = $recipe_avai->orderBy("created_at", "asc");
                    break;
                case "like_desc":
                    $aa = $recipe_avai->orderBy("created_at", "desc");
                    break;
            }
            $recipes = $aa->paginate(9)->appends('sort', $request->sort);
        } else {
            $recipes = $recipe_avai->orderBy("created_at", "desc")->paginate(9);
        }
        return view('page.search', compact('recipes', 'search'));
    }

    //autocomplete
    public function autocomplete(Request $request)
    {
        $search = $request->get('term');

        $result = Recipe::where('is_deleted', 0)->where("title", 'like', "%$search%")->get();

        return response()->json($result);
    }


    public function getRegister()
    {
        if (Auth::guest()) {
            return view('page.register');
        } else {
            return redirect()->action('PageController@getIndex');
        }
    }
    public function postRegister(Request $request)
    {
        $validatedData = $request->validate([
            'login_id' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6|max:25|unique:App\User,login_id',
            'nickname' => 'required|max:25',
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6',
            'repassword' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6|same:password',
        ], [
            'login_id.required' => 'ログインIDを入力してください',
            'login_id.regex' => 'アルファベット (a-z)、数字 (0-9)のみが使用できます',
            'login_id.max' => 'ログインIDは、25文字の間で設定する必要があります',
            'login_id.min' => 'ログインIDの長さは最低6文字です',
            'login_id.unique' => 'このログインIDは既に使用されています。別のログインIDを選択してください。',
            'nickname.required' => 'ニックネームを入力してください',
            'nickname.max' => 'ニックネームは、25文字の間で設定する必要があります',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードの長さは最低6文字です',
            'repassword.required' => 'もう一度パスワードを入力してください',
            'repassword.min' => 'パスワードの長さは最低6文字です。',
            'repassword.same' => 'パスワードが一致しません',
        ]);

        $user = new User;
        $user->login_id = $request->login_id;
        $user->nickname = $request->nickname;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->action('PageController@getLogin')->with('register-success', 'ログインしてみてください。');
    }

    public function getLogin(Request $request)
    {
        // lay url cua page ngay truoc khi truy cap vao page login
        session(['link' => url()->previous()]);
        if (Auth::guest()) {
            return view('page.login');
        } else {
            return redirect()->action('PageController@getIndex');
        }
    }

    public function postLogin(Request $request)
    {
        $validatedData = $request->validate([
            'login_id' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6|max:25',
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6',
        ], [
            'login_id.required' => 'ログインIDを入力してください',
            'login_id.regex' => 'アルファベット (a-z)、数字 (0-9)のみが使用できます。',
            'login_id.max' => 'ユーザーIDは、25文字の間で設定する必要があります。',
            'login_id.min' => 'ログインIDの長さは最低6文字です。',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードの長さは最低6文字です。',
        ]);

        $arr = [
            'login_id' => $request->login_id,
            'password' => $request->password
        ];

        if (Auth::attempt($arr)) {
            return redirect(session('link')); // return url vua lay duoc
        } else {
            return redirect('login')->with('login-error', 'このユーザーIDまたはパスワードは正しくありません。');
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->back();
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
        $recipe_likes = Recipe::find($request->id)->likes()->get();
        //dd($recipe_likes->where('is_liked', 1)); 
        // get user who created recipe for getting info
        $recipe_user = Recipe::find($request->id)->user()->first();
        return view('page.itemdetail', compact('recipe_material', 'recipe', 'recipe_imgs', 'recipe_user', 'recipe_likes'));
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
    public function getDeleteComment($id)
    {
        $comment = Comment::find($id);
        $comment->is_deleted = 1;
        $comment->save();

        return back();
    }

    public function getLike($id)
    {
        $like = new Liked;
        $like->user_id = Auth::user()->user_id;
        $like->recipe_id = $id;
        $like->save();

        return back();
    }
    public function getDeleteLike($id)
    {
        $like = Liked::find($id);
        $like->is_liked = 0;
        $like->save();

        return back();
    }
    public function getEditLike($id)
    {
        $like = Liked::find($id);
        $like->is_liked = 1;
        $like->save();

        return back();
    }


    public function getInputForm()
    {
        if (Auth::check()) {
            $material_master = MaterialMaster::all();
            return view('page.crud_recipe.add', compact('material_master'));
        } else {
            return redirect('login')->with('login-error', '投稿できるように、ログインが必須です。');
        }
    }
    public function postAddRecipe(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:25',
            'food_name' => 'required|max:25',
            'cook_time' => 'required|digits:4',
            'food_material' => 'required|max:255',
            'serving_for' => 'required|digits:2',
            'direction' => 'required|max:1000',
            'material' => 'required|array',
            'fileimg' => 'required|image',
        ], [
            'title.required' => 'タイトルを入力してください',
            'title.max' => 'タイトルは、25文字の間で設定する必要があります',
            'food_name.required' => '料理名を入力してください',
            'food_name.max' => '料理名は、25文字の間で設定する必要があります',
            'cook_time.required' => '作り時間を入力してください',
            'cook_time.max' => '作り時間は、1-999の間で設定する必要があります',
            'food_material.required' => '材料を入力してください',
            'food_material.max' => '材料は、255文字の間で設定する必要があります',
            'serving_for.required' => '何人前を入力してください',
            'serving_for.max' => '何人前は、1-99の間で設定する必要があります',
            'direction.required' => '作り方を入力してください',
            'direction.max' => '作り方は、1000文字の間で設定する必要があります',
            'fileimg.required' => 'レシピの写真を入力してください',
            'fileimg.image' => 'アップロードしたファイルは写真の形式ではない',
        ]);

        $recipe = new Recipe;
        $recipe->user_id = Auth::user()->user_id;
        $recipe->title = $request->title;
        $recipe->food_name = $request->food_name;
        $recipe->cook_time = $request->cook_time;
        $recipe->food_material = $request->food_material;
        $recipe->serving_for = $request->serving_for;
        $recipe->direction = $request->direction;
        $recipe->save();

        $master_materials = $request->material;
        foreach ($master_materials as $master_material) {
            $material = new Material;
            $material->recipe_id = $recipe->recipe_id;
            $material->material_master_id = $master_material;
            $material->save();
        }

        $files = $request->file('fileimg');
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $fileimg = Auth::user()->user_id . "_" . now()->format("YmdHis") . "_" . Str::random(4) . "." . $extension;
            $filepath = public_path('upload/recipe-img/');
            $file->move($filepath, $fileimg);
            $recipe_img = new RecipeImg();
            $recipe_img->recipe_id = $recipe->recipe_id;
            $recipe_img->recipe_img = $fileimg;
            $recipe_img->save();
        }

        return redirect()->action('PageController@getItemDetail', ['id' => $recipe->recipe_id]);
    }

    public function getEditRecipe($id)
    {
        if (Auth::check()) {
            $recipe = Recipe::find($id);
            // dd($recipe->materials_master()->first()->material_master_id);
            $material_master = MaterialMaster::all();
            $recipe_imgs = $recipe->recipes_img()->get();
            // dd($recipe->recipes_img()->get());
            return view('page.crud_recipe.edit', compact('recipe', 'material_master', 'recipe_imgs'));
        } else {
            return redirect()->action('PageController@getItemDetail', ['id' => $id]);
        }
    }
    public function postEditRecipe($id, Request $request)
    {
        $recipe = Recipe::find($id);
        $recipe->user_id = Auth::user()->user_id;
        $recipe->title = $request->title;
        $recipe->food_name = $request->food_name;
        $recipe->cook_time = $request->cook_time;
        $recipe->food_material = $request->food_material;
        $recipe->serving_for = $request->serving_for;
        $recipe->direction = $request->direction;
        $recipe->save();

        $master_materials = $request->material;
        foreach ($master_materials as $master_material) {
            $old = $request->oldmaterial;
        dd($old);
            $material = Material::where('recipe_id', $id)->where('material_master_id', $old)->first(); // dang sai vi $master_material la nguoi dung nhap vao. Khong phai la cai trong db
            $material->material_master_id = $master_material;
            $material->save();
        }


        $files = $request->file('fileimg');
        if ($files != NULL) {
            foreach ($files as $file) {
                $recipe_img = RecipeImg::find('recipe_id', $id)->first();
                $extension = $file->getClientOriginalExtension();
                $fileimg = Auth::user()->user_id . "_" . now()->format("YmdHis") . "_" . Str::random(4) . "." . $extension;
                $filepath = public_path('upload/recipe-img/');
                $file->move($filepath, $fileimg);
                unlink($filepath . $recipe_img->recipe_img);
                $recipe_img->recipe_id = $recipe->recipe_id;
                $recipe_img->recipe_img = $fileimg;
                $recipe_img->save();
            }
        }


        return redirect()->action('PageController@getItemDetail', ['id' => $recipe->recipe_id]);
    }

    public function getDeleteRecipe($id)
    {
        $recipe = Recipe::find($id);
        $recipe->is_deleted = 1;
        $recipe->save();

        return redirect()->action('PageController@getIndex');
    }
}
