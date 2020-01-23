@extends('master')
@section('content')
@push('styles')
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP&display=swap&subset=japanese" rel="stylesheet">
@endpush
<!-- Header -->
@include("../header")
<div class="container" style="font-family: 'Noto Serif JP', serif">
  <hr>
  <h1 class="my-4">Welcome to Modern Business</h1>

  <div class="row">
    @for($i=1;$i<= count($recipe);$i++) <!-- recipe get object and find recipe by id -->
      @foreach($recipe->where('recipe_id', $i) as $show_recipe)
      <div class="col-lg-4 col-sm-6 portfolio-item">
        <div class="card h-100">
          <a href="{{ URL::to('/itemdetail', $show_recipe->recipe_id) }}"><img class="card-img-top" src="{{$show_recipe->recipes_img()->first()->recipe_img}}" alt=""></a>
          <div class="card-body">
            <h4 class="card-title">
              <a href="{{ URL::to('/itemdetail', $show_recipe->recipe_id) }}">{{$show_recipe->title}}</a>
            </h4>
            <p class="card-text">{{$show_recipe->food_name}} <i class="far fa-clock"></i><span style="font-size: 13px;">- {{$show_recipe->cook_time}}分ぐらい</span></p>
            <p style="font-size: 12px;"><span style="font-size: 20px;">{{$show_recipe->user()->first()->nickname}}</span> - {{$show_recipe->created_at->format('Y年m月d日、h時m分s秒')}}</p>
          </div>
        </div>
      </div>
      @endforeach
      @endfor
  </div>
  <!-- /.row -->

  <!-- Features Section -->
  <div class="row">
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
  </div>
  <!-- /.row -->

  <hr>

  <!-- Call to Action Section -->
  <div class="row mb-4">
    <div class="col-md-8">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>
    </div>
    <div class="col-md-4">
      <a class="btn btn-lg btn-secondary btn-block" href="#">Call to Action</a>
    </div>
  </div>

</div>
@endsection