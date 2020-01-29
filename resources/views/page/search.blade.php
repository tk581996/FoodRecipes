@extends('master')
@section('content')
<!-- Header -->
@include("../header")
<div class="container">
    <hr>
    <div class="row">
        <select name="sort" onchange="location = this.value">
            <option value="">ソート</option>
            <option value="{{ URL::to('/search') }}/?search={{$search}}&&sort=created_at_desc">作成日時降順</option>
            <option value="{{ URL::to('/search') }}/?search={{$search}}&&sort=created_at_asc">作成日時昇順</option>
            <option value="{{ URL::to('/search') }}/?search={{$search}}&&sort=like_desc">人気</option>
        </select>

        <form method="get">
            <input type="text" id="textsend" onkeyup="success()" placeholder="検索" name="search">
            <button type="submit" id="button" disabled hidden>Submit</button>
        </form>
    </div>

    <hr>
    <h1 class="my-4">検索文字：{{$search}}</h1>

    <div class="row">
        @foreach($recipes as $show_recipe)
        <div class="col-lg-4 col-sm-6 portfolio-item">
            <div class="card h-100">
                <a href="{{ URL::to('/itemdetail', $show_recipe->recipe_id) }}"><img class="card-img-top" src="upload/recipe-img/{{$show_recipe->recipes_img()->first()->recipe_img}}" alt=""></a>
                <div class="card-body">
                    <h4 class="card-title">
                        <a href="{{ URL::to('/itemdetail', $show_recipe->recipe_id) }}">{!! str_ireplace($search,"<span style='color:red;'>$search</span>",$show_recipe->title) !!} </a>
                    </h4>
                    <p class="card-text">
                        {!! str_ireplace($search,"<span style='color:red;'>$search</span>",$show_recipe->food_name) !!}
                        <i class="far fa-clock" style='margin-left:20px'></i>
                        <span style="font-size: 13px;"> {!! str_ireplace($search,"<span style='color:red;'>$search</span>",$show_recipe->cook_time) !!}分ぐらい</span>
                        <i class="fas fa-heart" style='margin-left:20px;color: red;'></i>
                        <span>{{count($show_recipe->likes->where('is_liked',1))}}</span>
                    </p>
                    <p style="font-size: 12px;"><span style="font-size: 20px;">{{$show_recipe->user()->first()->nickname}}</span> - {{$show_recipe->created_at->format('Y年m月d日、H時i分s秒')}}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /.row -->
    <div class="row justify-content-center">{{$recipes->links()}}</div>
    <hr>

</div>

@push('scripts')
<script>
  function success() {
    var str = document.getElementById("textsend").value;
    if (str === "" || !$("#textsend").val().trim().length) {
      document.getElementById('button').disabled = true;
    } else {
      document.getElementById('button').disabled = false;
    }
  }
</script>
@endpush
@endsection