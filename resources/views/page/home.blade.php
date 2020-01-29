@extends('master')
@section('content')
<!-- Header -->
@push('scripts')
<script>
  function success() {
    var str = document.getElementById('textsend').value;
    if (str === "" || !$("#textsend").val().trim().length) {
      document.getElementById('button').disabled = true;
    } else {
      document.getElementById('button').disabled = false;
    }
  }
</script>
@endpush
@include("../header")
<div class="container">
  <hr>
  <div class="row">
    <select name="sort" onchange="location = this.value">
      <option value="">ソート</option>
      <option value="{{ URL::to('/index') }}/?sort=created_at_desc">作成日時降順</option>
      <option value="{{ URL::to('/index') }}/?sort=created_at_asc">作成日時昇順</option>
      <option value="{{ URL::to('/index') }}/?sort=like_desc">人気</option>
    </select>

    <form method="post" action="search">
      @csrf
      <input type="text" id="textsend" onkeyup="success()" placeholder="検索" name="search">
      <button type="submit" id="button" disabled hidden>Submit</button>
    </form>
  </div>

  <hr>
  <h1 class="my-4">いらっしゃいませ、こんにちは</h1>

  <div class="row">
    @foreach($recipes as $show_recipe)
    <div class="col-lg-4 col-sm-6 portfolio-item">
      <div class="card h-100">
        <a href="{{ URL::to('/itemdetail', $show_recipe->recipe_id) }}"><img class="card-img-top" src="upload/recipe-img/{{$show_recipe->recipes_img()->first()->recipe_img}}" height="234px" width="349px" alt=""></a>
        <div class="card-body">
          <h4 class="card-title" style="height:60px">
            <a href="{{ URL::to('/itemdetail', $show_recipe->recipe_id) }}">{{mb_strimwidth($show_recipe->title, 0, 40, "...")}}</a>
          </h4>
          <p class="card-text">{{mb_strimwidth($show_recipe->food_name, 0, 10, "...")}}
            <i class="far fa-clock" style='margin-left:20px'></i>
            <span style="font-size: 13px;"> {{$show_recipe->cook_time}}分ぐらい</span>
            <i class="fas fa-heart" style='margin-left:20px;color: red;'></i>
            <span>{{count($show_recipe->likes->where('is_liked',1))}}</span>
          </p>
          <span style="font-size: 20px;">{{mb_strimwidth($show_recipe->user()->first()->nickname, 0, 20, "...")}}</span>
          <p style="font-size: 12px;">{{$show_recipe->created_at->format('Y年m月d日、H時i分s秒')}}</p>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <!-- /.row -->
  <div class="row justify-content-center">{{$recipes->links()}}</div>
  <!-- Features Section -->
  <!-- <div class="row">
    <div class="col-lg-6">
      <h2>Modern Business Features</h2>
      <p>The Modern Business template by Start Bootstrap includes:</p>
      <ul>
        <li>
          <strong>Bootstrap v4</strong>
        </li>
        <li>jQuery</li>
        <li>Font Awesome</li>
        <li>Working contact form with validation</li>
        <li>Unstyled page elements for easy customization</li>
      </ul>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>
    </div>
    <div class="col-lg-6">
      <img class="img-fluid rounded" src="http://placehold.it/700x450" alt="">
    </div>
  </div> -->
  <!-- /.row -->

  <hr>

  <!-- Call to Action Section -->
  <!-- <div class="row mb-4">
    <div class="col-md-8">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
    </div>
    <div class="col-md-4">
      <a class="btn btn-lg btn-secondary btn-block" href="#">Call to Action</a>
    </div>
  </div> -->

</div>

@endsection