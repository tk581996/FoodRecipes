@extends('master')
@section('content')
@push('styles')
<style>
  .hover-img img {
    display: none;
    border: 1px solid green;
    border-radius: 20%;
    padding: 5px;
    background-color: white;
  }

  .hover-img:hover img {
    display: block;
    position: absolute;
    left: 67px;
    z-index: 1;
  }

  .hover-img:hover {
    color: red;
    text-decoration: none;
  }
</style>
<link href="../source/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../source/css/modern-business.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="../fontawesome/css/all.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP&display=swap&subset=japanese" rel="stylesheet">
@endpush
<!-- Page Content -->
<div class="container" style="font-family: 'Noto Serif JP', serif">

  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">{{$recipe->title}}
    <!-- <small>by
      <a href="#">Start Bootstrap</a>
    </small> -->
  </h1>

  <!-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="index.html">Home</a>
    </li>
    <li class="breadcrumb-item active">Blog Home 2</li>
  </ol> -->

  <hr>

  <!-- Date/Time -->
  <p style="font-style: italic;font-size: 15px">{{$recipe->created_at->format('Y年m月d日、h時m分s秒')}}</p>
  <p>投稿者：{{$recipe_user->nickname}}</p>

  <hr>


  <div class="row">

    <!-- Post Content Column -->
    <div class="col-lg-8">

      <!-- Carousel Image -->
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          @for($i=0;$i< count($recipe_imgs);$i++) @if ($i==0) <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="active">
            </li>
            @else
            <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
            @endif
            @endfor
        </ol>
        <div class="carousel-inner">
          @foreach($recipe_imgs as $recipe_img)
          @if($loop->first)
          <div class="carousel-item active">
            <img src="{{$recipe_img->recipe_img}}" style="height:490px;">
          </div>
          @else
          <div class="carousel-item">
            <img src="{{$recipe_img->recipe_img}}" style="height:490px;">
          </div>
          @endif
          @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

      <hr>
      <h2>作り方</h2>
      <hr>
      <!-- Post Content -->
      <p>
        @foreach(explode('。', $recipe->direction) as $direction)
        <option>{{ $direction }}</option>
        @endforeach
      </p>

      <hr>

      <!-- Comments Form -->
      @if(Auth::check())
      <div class="card my-4">
        <h5 class="card-header">Leave a Comment:</h5>
        <div class="card-body">
          <form method="post" action="comment/{{$recipe->recipe_id}}">
            <div class="form-group">
              <textarea class="form-control" rows="3" name="content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            {{ csrf_field() }}
          </form>
        </div>
      </div>
      @else
      <a href="{{ URL::to('/login') }}">コメントできるように、ログインしてください。</a>
      <hr>
      @endif

      <!-- Single Comment -->
      @foreach($recipe->comment as $comment)
      <div class="media mb-4">
        <div class="media-body">
          <h5 class="mt-0">
            {{$comment->user->nickname}}
            <small style="font-size: 13px;">{{$comment->created_at->format('Y年m月d日、h:m:s')}}</small>
          </h5>
          {{$comment->content}}
        </div>
      </div>
      @endforeach

    </div>

    <!-- Sidebar Widgets Column -->
    <div class="col-md-4">
      <!-- 調味料 -->
      <div class="card mb-4">
        <h5 class="card-header">調味料</h5>
        <div class="card-body">
          <div class="row">
            @foreach($recipe_material as $material)
            <div class="col-lg-6">
              <ul class="list-unstyled mb-0">
                <li>
                  <a href="{{$material->material_img}}" class="hover-img">
                    ・{{$material->material_name}}
                    <img src="{{$material->material_img}}" height="100px">
                  </a>
                </li>
              </ul>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- Food name + cook time -->
      <div class="card my-4">
        <h5 class="card-header">{{$recipe->food_name}}</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8">
              <p><i class="far fa-clock"></i> 作り時間：{{$recipe->cook_time}}分ぐらい</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Material -->
      <div class="card my-4">
        <h5 class="card-header">材料（{{$recipe->serving_for}}人前）</h5>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8">
              <p>
                @foreach(explode(',', $recipe->food_material) as $info)
                <option>{{ $info }}</option>
                @endforeach
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->
@push('scripts')
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
@endpush
@endsection