@extends('master')
@section('content')
@push('styles')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link href="css/input-form.scss" rel="stylesheet">
@endpush
<div class="testbox">
    <form action="/">
        <div class="banner">
            <h1>レシピ追加</h1>
        </div>
        <div class="item">
            <label for="apply">投稿タイトル</label>
            <input id="apply" type="text" name="title" />
        </div>
        <div class="item">
            <label for="period">料理名</label>
            <input id="period" type="text" name="food_name" />
        </div>
        <div class="item">
            <label for="period">作り時間</label>
            <input id="period" type="number" name="cook_time" min='0' max='9999' />
        </div>
        <div class="item">
            <label for="period">調味料</label>
            <div class="city-item" id="buildyourform">
                <select required>
                    <option value="">――――――調味料を選んでください――――――</option>
                    @foreach($material_master as $material_master)
                    <option value="">{{$material_master->material_name}}</option>
                    @endforeach
                </select>
            </div>
            <input type="button" value="Add a field" class="add" id="add" />
        </div>
        <div class="item">
            <label for="period">材料</label>
            <textarea type="text" name="food_name"></textarea>
        </div>
        <div class="item">
            <label for="period">何人前</label>
            <input id="period" type="number" name="serving_for" min='1' max='100' />
        </div>
        <div class="item">
            <label for="period">作り方</label>
            <textarea type="text" name="direction"></textarea>
        </div>

        <div class="item">
            <label for="cv">Upload CV<span>*</span></label>
            <input id="cv" type="file" required />
        </div>
        <div class="item">
            <label for="cover">Cover Letter<span>*</span></label>
            <input id="cover" type="file" required />
        </div>
        <div class="item">
            <label for="picture">Upload Picture</label>
            <input id="picture" type="file" />
        </div>
        <div class="item">
            <label for="video">Video Presentation</label>
            <input id="video" type="file" />
        </div>
        <div class="btn-block">
            <button type="submit" href="/">APPLY</button>
        </div>
    </form>
</div>
@push('scripts')
<script>
    $(document).ready(function() {
        $("#add").click(function() {
            var lastField = $("#buildyourform div:last");
            var intId = (lastField && lastField.length && lastField.data("idx") + 1) || 1;
            var fieldWrapper = $("<div id=\"field" + intId + "\"/>");
            fieldWrapper.data("idx", intId);
            var fName = $("<select type=\"text\" class=\"fieldname\"><select>");
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
@endsection