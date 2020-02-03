@extends('master')
@section('content')
@push('styles')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
{{ HTML::style('css/input-form.css')}}
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        $("#add").click(function() {
            var lastField = $("#buildyourform div:last");
            var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
            var fieldWrapper = $("<div class=\"city-item\" id=\"field" + intId + "\"/>");
            fieldWrapper.data("idx", intId);
            var fName = $("<select id=\"sel\" onchange=\"confirm(\'調味料を編集する？\')\" required name=\"material[]\"><option value=\"0\">――――――調味料を選んでください――――――</option>@foreach($material_master as $material)<option value=\"{{$material->material_master_id}}\">{{$material->material_name}}</option>@endforeach</select>");
            var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fName);
            fieldWrapper.append(removeButton);
            $("#buildyourform").append(fieldWrapper);
        });
    });

    $(document).ready(function() {
        $('input[type="file"]').change(function(event) {
            var fileSize = this.files[0].size;
            var maxAllowedSize = 2097152;
                // check the file size if its greater than requirement
                if (fileSize > maxAllowedSize) {
                    alert('写真サイズは2048kBを超える。より小さい写真サイズをアップロードしてください。');
                    this.val('');
                }

        });
    });
</script>
@endpush
<div class="testbox">
    <!-- form with upload img have to enctype="...." to available -->
    <form method="post" action="{{$recipe->recipe_id}}" enctype="multipart/form-data">
        <div class="banner">
            <h1>レシピ編集</h1>
        </div>
        <div class="item">
            <label for="apply">投稿タイトル</label>
            <input id="apply" class="@error('title') is-invalid @enderror" type="text" name="title" value="{{$recipe->title}}" />
        </div>
        @error('title')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label for="period">料理名</label>
            <input id="period" class="@error('food_name') is-invalid @enderror" type="text" name="food_name" value="{{$recipe->food_name}}" />
        </div>
        @error('food_name')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label for="period">作り時間</label>
            <input id="period" class="@error('cook_time') is-invalid @enderror" type="number" name="cook_time" min='0' max='9999' value="{{$recipe->cook_time}}" />
        </div>
        @error('cook_time')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item" id="buildyourform">
            <label for="period">調味料</label>
            <div class="city-item">
                @foreach($recipe->materials_master()->get() as $recipe_mm)
                <select required onchange="confirm('調味料を編集する？')" name="material[]">
                    <option value="0">――――――調味料を選んでください――――――</option>
                    @foreach($material_master as $mm)
                    <option @if($recipe_mm->material_master_id == $mm->material_master_id )
                        {{"selected"}}
                        @endif
                        value="{{$mm->material_master_id}}">
                        {{$mm->material_name}}
                    </option>
                    @endforeach
                </select>
                <input hidden name="oldmaterial[]" value="{{$recipe_mm->material_master_id}}" />
                @endforeach
            </div>
        </div>
        @if(session('material-error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{session('material-error')}}</div>
		@endif
        <input type="button" value="調味料を追加" class="add" id="add" />
        <div class="item">
            <label for="period">材料</label>
            <textarea type="text" class="@error('food_material') is-invalid @enderror" name="food_material">{{$recipe->food_material}}</textarea>
        </div>
        @error('food_material')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label for="period">何人前</label>
            <input id="period" class="@error('serving_for') is-invalid @enderror" type="number" name="serving_for" min='1' max='100' value="{{$recipe->serving_for}}" />
        </div>
        @error('serving_for')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label for="period">作り方</label>
            <textarea type="text" class="@error('direction') is-invalid @enderror" name="direction" rows="3">{{$recipe->direction}}</textarea>
        </div>
        @error('direction')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item" id="img">
            <label for="cv">レシピ写真</label>
            <p>
                @foreach($recipe_imgs as $img)
                <img height="130px" src="../../upload/recipe-img/{{$img->recipe_img}}">
                <input hidden name="oldfileimg[]" value="{{$img->recipe_img}}" />
                @endforeach
            </p>
            <input type="file" name="fileimg[]" multiple />
        </div>
        @if(session('img-error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{session('img-error')}}</div>
		@endif
        <input type="button" value="写真を追加" class="add" id="add-img" />

        <div class="btn-block">
            <button type="submit" href="/">編集</button>
        </div>
        {{ csrf_field() }}
    </form>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $("#add-img").click(function() {
            var lastField = $("#img div:last");
            var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
            var fieldWrapper = $("<div class=\"item\" id=\"field" + intId + "\"/>");
            fieldWrapper.data("idx", intId);
            var fName = $("<input name=\"fileimg[]\" type=\"file\" multiple/>");
            var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fName);
            fieldWrapper.append(removeButton);
            $("#img").append(fieldWrapper);
        });
    });
</script>
@endpush
@endsection