@extends('master')
@section('content')
@push('styles')
<!--Login form-->
{{ HTML::style("login_sourse/css/util.css")}}
{{ HTML::style("login_sourse/css/main.scss")}}
<!--===============================================================================================-->
@endpush
<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-form-title" style="background-image: url(https://www.aco-mom.com/images/izakaya/2015/20170912-izakaya-nimono-00.jpg);">
				<span class="login100-form-title-1">
					ログイン
				</span>
			</div>
			@if(session('login-error'))
			<div class="alert alert-danger row">
				<div class="col-2 d-flex justify-content-end" style='font-size:24px;top:6px;right:-20px;'><i class="fas fa-exclamation-triangle"></i></div>
				<div class="col-10">
					<h3>問題が発生しました。</h3>
					<h5 style="color:red;">{{session('login-error')}}</h5>
				</div>
			</div>
			@elseif(session('register-success'))
			<div class="alert alert-success row">
				<div class="col-2 d-flex justify-content-end" style='font-size:24px;top:6px;right:-20px;'><i class="fas fa-check-circle"></i></div>
				<div class="col-10">
					<h3>登録成功。</h3>
					<h5 style="color:red;">{{session('register-success')}}</h5>
				</div>
			</div>
			@endif
			<form method="post" action="{{ url('/login') }}" class="login100-form validate-form">
				<div class="wrap-input100 validate-input m-b-26" data-validate="ユーザーIDが必須">
					<span class="label-input100">ログインID</span>
					<input class="input100  @error('login_id') is-invalid @enderror" type="text" name="login_id" placeholder="ユーザーIDを入力">
				</div>
				@error('login_id')
				<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
				@enderror

				<div class="wrap-input100 validate-input m-b-18" data-validate="パスワードが必須">
					<span class="label-input100">パスワード</span>
					<input class="input100 @error('password') is-invalid @enderror" type="password" name="password" placeholder="パスワードを入力">
				</div>
				@error('password')
				<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
				@enderror

				<div class="container-login100-form-btn">
					<button type="submit" class="login100-form-btn">
						ログイン
					</button>
				</div>
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
<!--===============================================================================================-->
@endpush
@endsection