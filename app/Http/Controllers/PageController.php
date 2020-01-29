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
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
                    $aa = Recipe::where('is_deleted', 0)->withCount(['likes' => function (EloquentBuilder $query) {
                        $query->where('is_liked', 1);
                    }])->orderBy("likes_count", 'desc');
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
                    $aa = Recipe::where('is_deleted', 0)->withCount(['likes' => function (EloquentBuilder $query) {
                        $query->where('is_liked', 1);
                    }])->orderBy("likes_count", 'desc');
                    break;
            }
            $recipes = $aa->paginate(9)->appends('sort', $request->sort);
        } else {
            $recipes = $recipe_avai->orderBy("created_at", "desc")->paginate(9);
        }
        return view('page.search', compact('recipes', 'search'));
    }

    //autocomplete
    // public function autocomplete(Request $request)
    // {
    //     $search = $request->get('term');

    //     $result = Recipe::where('is_deleted', 0)->where("title", 'like', "%$search%")->get();

    //     return response()->json($result);
    // }


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
        $recipe_comments = $recipe->comments()->orderBy('created_at', 'DESC')->get();
        return view('page.itemdetail', compact('recipe_material', 'recipe', 'recipe_imgs', 'recipe_user', 'recipe_likes', 'recipe_comments'));
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
            'cook_time' => 'required|max:4',
            'food_material' => 'required|max:255',
            'serving_for' => 'required|max:2',
            'direction' => 'required|max:1000',
            'material' => 'required|array',
            'fileimg' => 'required',
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
            'fileimg.mimes' => 'アップロードしたファイルは写真の形式ではない',
        ]);

        //check neu anh khong dung dinh dang
        $list_extension = ['jpeg', 'jpg', 'jpe', 'png', 'svg', 'webp'];
        $files = $request->file('fileimg');
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            if (in_array($extension, $list_extension) == false) {
                return redirect('inputform')->with('img-error', 'アップロードしたファイルは写真の形式ではない。');
            }
        }

        //check neu trug gia vi
        $master_materials = $request->material;
        $exist = [];
        for ($i = 0; $i < count($master_materials); $i++) {
            if ($master_materials[$i] == '0') {
                return redirect('inputform')->with('material-error', '調味料の選んでください。');
            }
        }
        foreach ($master_materials as $master_material) {
            if (in_array($master_material, $exist) == false) {
                array_push($exist, $master_material);
            } else {
                return redirect('inputform')->with('material-error', '調味料の選びは重複できません。');
            }
        }

        $recipe = new Recipe;
        $recipe->user_id = Auth::user()->user_id;
        $recipe->title = $request->title;
        $recipe->food_name = $request->food_name;
        $recipe->cook_time = $request->cook_time;
        $recipe->food_material = $request->food_material;
        $recipe->serving_for = $request->serving_for;
        $recipe->direction = $request->direction;
        $recipe->save();


        foreach ($master_materials as $master_material) {
            $material = new Material;
            $material->recipe_id = $recipe->recipe_id;
            $material->material_master_id = $master_material;
            $material->save();
        }

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
        $validatedData = $request->validate([
            'title' => 'required|max:25',
            'food_name' => 'required|max:25',
            'cook_time' => 'required|max:4',
            'food_material' => 'required|max:255',
            'serving_for' => 'required|max:2',
            'direction' => 'required|max:1000',
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
            // 'fileimg.required' => 'レシピの写真を入力してください',
            // 'fileimg.mimes' => 'アップロードしたファイルは写真の形式ではない',
        ]);
        $list_extension = ['jpeg', 'jpg', 'jpe', 'png', 'svg', 'webp'];
        $files = $request->file('fileimg');
        if ($files != NULL) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                if (in_array($extension, $list_extension) == false) {
                    return back()->with('img-error', 'アップロードしたファイルは写真の形式ではない。');
                }
            }
        }

        //check neu trug gia vi
        $master_materials = $request->material;
        $exist = [];
        for ($i = 0; $i < count($master_materials); $i++) {
            if ($master_materials[$i] == '0') {
                return redirect('inputform')->with('material-error', '調味料の選んでください。');
            }
        }
        foreach ($master_materials as $master_material) {
            if (in_array($master_material, $exist) == false) {
                array_push($exist, $master_material);
            } else {
                return redirect('inputform')->with('material-error', '調味料の選びは重複できません。');
            }
        }

        $recipe = Recipe::find($id);
        $recipe->user_id = Auth::user()->user_id;
        $recipe->title = $request->title;
        $recipe->food_name = $request->food_name;
        $recipe->cook_time = $request->cook_time;
        $recipe->food_material = $request->food_material;
        $recipe->serving_for = $request->serving_for;
        $recipe->direction = $request->direction;
        $recipe->save();

        $old = $request->oldmaterial;
        $oldcount = count($old);
        $new = $master_materials;
        $newcount = count($new);
        $arr = [$old, $new]; //0 la gia tri cu=>old, 1 la gia tri moi => new
        if ($newcount == $oldcount) { //update
            for ($i = 0; $i < count($new); $i++) {
                if ($arr[0][$i] != $arr[1][$i]) {
                    $test = DB::table('material')->where('recipe_id', $id)->where('material_master_id', $arr[0][$i])->update(['material_master_id' => $arr[1][$i]]);
                }
            }
        } else { //create new
            $tmp = $newcount - $oldcount;
            for ($i = 0; $i < $tmp; $i++) {
                DB::table('material')->insert(
                    ['recipe_id' => $id, 'material_master_id' => $arr[1][$oldcount + $i]]
                );
            }
        }

        $oldimg = $request->oldfileimg;
        $newimg = [];
        if ($files != NULL) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $fileimg = Auth::user()->user_id . "_" . now()->format("YmdHis") . "_" . Str::random(4) . "." . $extension;
                array_push($newimg, $fileimg);
            }
            $newimgcount = count($newimg);
            $oldimgcount = count($oldimg);
            $arrfile = [$oldimg, $newimg];
            $filepath = public_path('upload/recipe-img/');
            if ($newimgcount <= $oldimgcount) { //update
                for ($i = 0; $i < $newimgcount; $i++) {
                    $test = DB::table('recipe_img')->where('recipe_id', $id)->where('recipe_img', $arrfile[0][$i])->update(['recipe_img' => $arrfile[1][$i]]);
                    $file->move($filepath, $arrfile[1][$i]);
                }
            } else { //create new
                $tmp = $newimgcount - $oldimgcount;
                for ($i = 0; $i < $tmp; $i++) {
                    DB::table('recipe_img')->insert(
                        ['recipe_id' => $id, 'recipe_img' => $arr[1][$oldimgcount + $i]]
                    );
                    $file->move($filepath, $arrfile[1][$i]);
                }
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
