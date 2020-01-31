@extends('master')
@section('content')
<!-- Header -->
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

    //search autocomplete
    $(document).ready(function() {
        $('#textsend').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/index/autocomplete') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token //pass csrf
                    },
                    success: function(data) {
                        $('#searchList').fadeIn();
                        $('#searchList').html(data);
                    }
                });
            } else {
                $('#searchList').fadeOut();
            }
        });
        $(document).on('click', 'li', function() {
            $('#textsend').val($(this).text());
            $('#searchList').fadeOut();
        }); // can pick tag <li> in hint list
        $('#textsend').blur(function() {
            $('#searchList').fadeOut();
            // hive searchlist when blur
        });
    });
</script>
@endpush
@include("../header")
<div class="container">
    <hr>
    <div class="row justify-content-end">
    <div class="col-6">
      <form method="post" action="search">
        @csrf
        <input type="text" id="textsend" autocomplete="off" onkeyup="success()" placeholder="検索" name="search">
        <div id="searchList"></div>
        <button type="submit" id="button" disabled hidden>Submit</button>
      </form>
    </div>
    <div class="col-2">
      <select name="sort" class="sort" onchange="location = this.value">
        <option>ソート</option>
        <option value="{{ URL::to('/index') }}/?sort=created_at_desc">作成日時降順</option>
        <option value="{{ URL::to('/index') }}/?sort=created_at_asc">作成日時昇順</option>
        <option value="{{ URL::to('/index') }}/?sort=like_desc">人気</option>
      </select>
    </div>
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

@endsection