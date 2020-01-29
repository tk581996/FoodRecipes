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
            var fName = $("<select name=\"material[]\"><option value=\"0\">――――――調味料を選んでください――――――</option>@foreach($material_master as $material)<option value=\"{{$material->material_master_id}}\">{{$material->material_name}}</option>@endforeach</select>");
            var removeButton = $("<input type=\"button\" class=\"remove\" value=\"-\" />");
            removeButton.click(function() {
                $(this).parent().remove();
            });
            fieldWrapper.append(fName);
            fieldWrapper.append(removeButton);
            $("#buildyourform").append(fieldWrapper);
        });
    });
</script>
@endpush
<div class="testbox">
    <!-- form with upload img have to enctype="...." to available -->
    <form method="post" action="{{ URL::to('inputform/add') }}" files=true enctype="multipart/form-data">
        @csrf
        <div class="banner">
            <h1>レシピ追加</h1>
        </div>
        <div class="item">
            <label>投稿タイトル</label>
            <input class="@error('title') is-invalid @enderror" type="text" name="title" />
        </div>
        @error('title')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label>料理名</label>
            <input class="@error('food_name') is-invalid @enderror" type="text" name="food_name" />
        </div>
        @error('food_name')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label>作り時間</label>
            <input class="@error('cook_time') is-invalid @enderror" type="number" name="cook_time" min='0' max='9999' />
        </div>
        @error('cook_time')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item" id="buildyourform">
            <label>調味料</label>
            <div class="city-item">
                <select name="material[]" class="@error('material') is-invalid @enderror" required>
                    <option value="0">――――――調味料を選んでください――――――</option>
                    @foreach($material_master as $material_master)
                    <option value="{{$material_master->material_master_id}}"> {{$material_master->material_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @if(session('material-error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{session('material-error')}}</div>
		@endif
        @error('material')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror
        <input type="button" value="調味料を追加" class="add" id="add" />

        <div class="item">
            <label>材料</label>
            <textarea type="text" class="@error('food_material') is-invalid @enderror" name="food_material"></textarea>
        </div>
        @error('food_material')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label >何人前</label>
            <input class="@error('serving_for') is-invalid @enderror" type="number" name="serving_for" min='1' max='100' />
        </div>
        @error('serving_for')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item">
            <label>作り方</label>
            <textarea type="text" class="@error('direction') is-invalid @enderror" name="direction" rows="3"></textarea>
        </div>
        @error('direction')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror

        <div class="item" id="img">
            <label>レシピ写真<span>*</span></label>
            <input id="cv" class="@error('fileimg') is-invalid @enderror" type="file" name="fileimg[]" multiple />
        </div>
        @if(session('img-error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{session('img-error')}}</div>
		@endif
        @error('fileimg')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
        @enderror
        <input type="button" value="写真を追加" class="add" id="add-img" />

        <div class="btn-block">
            <button type="submit" href="/">作成</button>
        </div>
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