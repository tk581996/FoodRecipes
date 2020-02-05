@extends('master')
@section('content')
@push('styles')
<!--Login form-->
{{ HTML::style("login_sourse/css/util.css")}}
{{ HTML::style("login_sourse/css/main.scss")}}
<!--===============================================================================================-->
@endpush
@push('scripts')
<script>
    $('#changepw').change(function() {
        if ($(this).is(':checked')) {
            $('#pw').removeAttr('disabled');
            $('#repw').removeAttr('disabled');
        } else {
            $('#pw').attr('disabled', '');
            $('#repw').attr('disabled', '');
        }
    })
</script>
@endpush
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(https://mirai-image.jp/wp-content/uploads/2020/01/3d4761e2371f555c046cbd32f6f6d955-1-800x480.png);">
                <span class="login100-form-title-1">
                    プロファイル編集
                </span>
            </div>

            @if(session('register-success'))
			<div class="alert alert-success row">
				<div class="col-2 d-flex justify-content-end" style='font-size:24px;top:6px;right:-20px;'><i class="fas fa-check-circle"></i></div>
				<div class="col-10">
					<h3>{{session('register-success')}}</h3>
				</div>
			</div>
			@endif

            <form method="post" action="{{ url('/edituser') }}" class="login100-form validate-form">
                @csrf
                <div class="wrap-input100 validate-input m-b-26">
                    <span class="label-input100">ログインID</span>
                    <input class="input100" type="text" name="login_id" disabled value="{{Auth::user()->login_id}}">
                </div>

                <div class="wrap-input100 validate-input m-b-26">
                    <span class="label-input100">ニックネーム</span>
                    <input class="input100 @error('nickname') is-invalid @enderror" type="text" name="nickname" value="{{Auth::user()->nickname}}">
                </div>
                @error('nickname')
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                @enderror

                <!-- change password checkbox -->
                <input type="checkbox" id="changepw" name="changepw" value='on'>  

                <div class="wrap-input100 validate-input m-b-18">
                    <span class="label-input100">パスワード</span>
                    <input class="input100 @error('password') is-invalid @enderror" id="pw" disabled type="password" name="password" placeholder="パスワードを入力">
                    <span class="focus-input100"></span>
                </div>
                @error('password')
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                @enderror

                <div class="wrap-input100 validate-input m-b-18">
                    <span class="label-input100">もう一度<br>パスワード</span>
                    <input class="input100 @error('repassword') is-invalid @enderror" id="repw" disabled type="password" name="repassword" placeholder="パスワードを入力">
                    <span class="focus-input100"></span>
                </div>
                @error('repassword')
                <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                @enderror

                <div class="container-login100-form-btn">
                    <button onclick="this.disabled=true;this.form.submit();" type="submit" class="login100-form-btn">
                        更新
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<!-- JS login -->
{{ HTML::script("login_sourse/vendor/jquery/jquery-3.2.1.min.js")}}
<!--===============================================================================================-->
{{ HTML::script("login_sourse/vendor/animsition/js/animsition.min.js")}}
<!--===============================================================================================-->
{{ HTML::script("login_sourse/vendor/bootstrap/js/popper.js")}}
<!--===============================================================================================-->
{{ HTML::script("login_sourse/vendor/select2/select2.min.js")}}
<!--===============================================================================================-->
{{ HTML::script("login_sourse/vendor/daterangepicker/moment.min.js")}}
{{ HTML::script("login_sourse/vendor/daterangepicker/daterangepicker.js")}}
<!--===============================================================================================-->
{{ HTML::script("login_sourse/vendor/countdowntime/countdowntime.js")}}
@endpush
@endsection