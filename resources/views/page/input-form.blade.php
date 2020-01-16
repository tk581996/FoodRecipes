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
            <label for="name">Name<span>*</span></label>
            <div class="name-item">
                <input id="name" type="text" name="name" placeholder="First" required />
                <input id="name" type="text" name="name" placeholder="Last" required />
            </div>
        </div>
        <div class="item">
            <label for="bdate">Date of Birth<span>*</span></label>
            <input id="bdate" type="date" name="bdate" required />
            <i class="fas fa-calendar-alt"></i>
        </div>
        <div class="item">
            <div class="name-item">
                <div>
                    <label for="address">Email Address<span>*</span></label>
                    <input id="address" type="text" name="address" required />
                </div>
                <div>
                    <label for="number">Phone Number</label>
                    <input id="number" type="tel" name="number" />
                </div>
            </div>
        </div>
        <div class="item">
            <div class="name-item">
                <div>
                    <label for="language">Which languages do you speak?</label>
                    <input id="language" type="text" name="languages" />
                </div>
                <div>
                    <label for="nationality">Nationality of your Passport</label>
                    <input id="nationality" type="text" name="Nationality" />
                </div>
            </div>
        </div>
        <div class="item">
            <div class="name-item">
                <div>
                    <label for="country">In which country do you like to get a job?</label>
                    <input id="country" type="text" name="country" />
                </div>
                <div>
                    <label for="job">The job you want to apply for?</label>
                    <input id="job" type="text" name="job" />
                </div>
            </div>
        </div>
        <div class="item">
            <label for="apply">Why do you apply for this job?</label>
            <input id="apply" type="text" name="text" />
        </div>
        <div class="item">
            <label for="period">The period you would like to work in this job?</label>
            <input id="period" type="text" name="text" />
        </div>
        <div class="item">
            <label for="period">Select country?</label>
            <div class="city-item">
                <select required>
                    <option value="">Country</option>
                    @foreach($material_master as $material_master)
                    <option value="">{{$material_master->material_name}}</option>
                    @endforeach
                </select>
            </div>
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
@endsection