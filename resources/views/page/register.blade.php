@extends('master')
@section('content')
@push('styles')
<!--Login form-->
{{ HTML::style("login_sourse/css/util.css")}}
{{ HTML::style("login_sourse/css/main.scss")}}
<!--===============================================================================================-->
@endpush
<div class="limiter" >
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-form-title" style="background-image: url(https://mirai-image.jp/wp-content/uploads/2020/01/3d4761e2371f555c046cbd32f6f6d955-1-800x480.png);">
				<span class="login100-form-title-1">
					ユーザー新規登録
				</span>
			</div>

			<form method="post" action="{{ url('/register') }}" class="login100-form validate-form">
				<div class="wrap-input100 validate-input m-b-26" data-validate="ユーザーIDが必須">
					<span class="label-input100">ログインID</span>
					<input class="input100 @error('login_id') is-invalid @enderror" type="text" name="login_id" placeholder="ユーザーIDを入力">
				</div>
				@error('login_id')
				<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
				@enderror
                
                <div class="wrap-input100 validate-input m-b-26" data-validate="ニックネームが必須">
					<span class="label-input100">ニックネーム</span>
					<input class="input100 @error('nickname') is-invalid @enderror" type="text" name="nickname" placeholder="ニックネームを入力">
				</div>
				@error('nickname')
				<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
				@enderror

				<div class="wrap-input100 validate-input m-b-18" data-validate="パスワードが必須">
					<span class="label-input100">パスワード</span>
					<input class="input100 @error('password') is-invalid @enderror" type="password" name="password" placeholder="パスワードを入力">
					<span class="focus-input100"></span>
				</div>
				@error('password')
				<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
				@enderror 
                
                <div class="wrap-input100 validate-input m-b-18" data-validate="パスワードが必須">
					<span class="label-input100">もう一度パスワードを入力してください</span>
					<input class="input100 @error('repassword') is-invalid @enderror" type="password" name="repassword" placeholder="パスワードを入力">
					<span class="focus-input100"></span>
				</div>
				@error('repassword')
				<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
				@enderror
				
				<div class="container-login100-form-btn">
					<button type="submit" class="login100-form-btn">
						アカウントを作成
					</button>
				</div>
				<a href="{{ URL::to('login') }}" style="margin-top:10px">ログイン</a>
				{{ csrf_field() }}
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