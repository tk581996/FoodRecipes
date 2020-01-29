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
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
@endpush
<!-- Page Content -->
<div class="container">

  <!-- Page Heading/Breadcrumbs -->
  <h1 class="mt-4 mb-3">{{$recipe->title}}
    <small>
      <!-- neu chua dang nhap thi hien thi tim khong mau -->
      @if(Auth::guest())
      <a href="{{ URL::to('/login')}}" style="color: red;"><i class="far fa-heart"></i></a>
      @else
      <!-- hoac neu nguoi dug chua co id trong bang liked thi create liked -->
      @if((count($recipe_likes->where('user_id',Auth::id()))) == 0)
      <a href="like/{{$recipe->recipe_id}}" style="color: red;"><i class="far fa-heart"></i></a>
      @endif
      @endif

      @foreach($recipe_likes->where('is_liked',1) as $like)
      @if(Auth::check() && $like->user_id == Auth::user()->user_id)
      <!-- chuyen is_like ve 0 -> trang thai chua like -->
      <a href="like/delete/{{$like->liked_id}}" style="color: red;"><i class="fas fa-heart"></i></a>
      @endif
      @endforeach

      @foreach($recipe_likes->where('is_liked',0) as $like)
      @if(Auth::check() && $like->user_id == Auth::user()->user_id)
      <!-- chuyen is_like ve 1 -> trang thai da like -->
      <a href="like/edit/{{$like->liked_id}}" style="color: red;"><i class="far fa-heart"></i></a>
      @endif
      @endforeach

      {{count($recipe_likes->where('is_liked',1))}}
    </small>
    @if(Auth::check() && Auth::user()->user_id == $recipe->user_id)
    <div class="float-right">
      <a href="{{ url('/inputform/edit/'.$recipe->recipe_id) }}" class="btn btn-success">編集</a>
      <a href="{{ url('/inputform/delete/'.$recipe->recipe_id) }}" onclick="return confirm('本当に削除？');" class="btn btn-danger">削除</a>
    </div>
    @endif
  </h1>

  <!-- <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="index.html">Home</a>
    </li>
    <li class="breadcrumb-item active">Blog Home 2</li>
  </ol> -->

  <hr>

  <!-- Date/Time -->
  <p style="font-style: italic;font-size: 15px">{{$recipe->created_at->format('Y年m月d日、H時i分s秒')}}</p>
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
            <img src="../upload/recipe-img/{{$recipe_img->recipe_img}}" style="height:490px;">
          </div>
          @else
          <div class="carousel-item">
            <img src="../upload/recipe-img/{{$recipe_img->recipe_img}}" style="height:490px;">
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

      @foreach(explode('。', $recipe->direction) as $direction)
      <p>{{ $direction }}</p>
      @endforeach


      <hr>

      <!-- Comments Form -->
      @if(Auth::check())
      <div class="card my-4">
        <h5 class="card-header">コメントしてください：</h5>
        <div class="card-body">
          <form method="post" action="comment/{{$recipe->recipe_id}}">
            <div class="form-group">
              <textarea class="form-control" onkeyup="success()" id="textsend" rows="3" name="content"></textarea>
            </div>
            <button type="submit" id="button" class="btn btn-primary" disabled>コメント</button>
            {{ csrf_field() }}
          </form>
        </div>
      </div>
      @else
      <a href="{{ URL::to('/login') }}">コメントできるように、ログインしてください。</a>
      <hr>
      @endif

      <!-- Single Comment -->
      @foreach($recipe->comments as $comment)
      @if($comment->is_deleted == 0)
      <div class="media mb-4">
        <div class="media-body">
          <h5 class="mt-0">
            {{$comment->user->nickname}}
            <small style="font-size: 13px;">{{$comment->created_at->format('Y年m月d日、h:m:s')}}</small>
            @if(Auth::check() && Auth::user()->user_id == $comment->user_id)
            <a href="comment/delete/{{$comment->comment_id}}" onclick="return confirm('本当に削除？');" class="btn btn-danger">削除</a>
            @endif
          </h5>
          {{$comment->content}}
        </div>
      </div>
      @endif
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
            <div class="col-lg-12">
                @foreach(explode(',', $recipe->food_material) as $info)
                <p>・{{ $info }}<p>
                @endforeach
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