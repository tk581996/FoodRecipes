@extends('master')
@section('content')
@push('styles')
<!--Login form-->
<link rel="icon" type="image/png" href="login_sourse/images/icons/favicon.ico" />
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/vendor/select2/select2.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="login_sourse/css/util.css">
<link rel="stylesheet" type="text/css" href="login_sourse/css/main.css">
<!--===============================================================================================-->
@endpush
<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-form-title" style="background-image: url(https://www.aco-mom.com/images/izakaya/2015/20170912-izakaya-nimono-00.jpg);">
				<span class="login100-form-title-1">
					Sign In
				</span>
			</div>

			<form method="post" action="{{ url('/login') }}" class="login100-form validate-form">
				<div class="wrap-input100 validate-input m-b-26" data-validate="ユーザーIDが必須">
					<span class="label-input100">ログインID</span>
					<input class="input100" type="text" name="loginid" placeholder="ユーザーIDを入力">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-18" data-validate="パスワードが必須">
					<span class="label-input100">パスワード</span>
					<input class="input100" type="password" name="password" placeholder="パスワードを入力">
					<span class="focus-input100"></span>
				</div>
				
				<div class="container-login100-form-btn">
					<button type="submit" class="login100-form-btn">
						ログイン
					</button>
				</div>
				<div class="flex-sb-m w-full p-b-30">
					<div>
						<a href="#" class="txt1">
							Forgot Password?
						</a>
					</div>
				</div>
				{{ csrf_field() }}
			</form>
		</div>
	</div>
</div>
@push('scripts')
<!-- JS login -->
<script src="login_sourse/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="login_sourse/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="login_sourse/vendor/bootstrap/js/popper.js"></script>
<!--<script src="login_sourse/vendor/bootstrap/js/bootstrap.min.js"></script>-->
<!--===============================================================================================-->
<script src="login_sourse/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="login_sourse/vendor/daterangepicker/moment.min.js"></script>
<script src="login_sourse/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="login_sourse/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="login_sourse/js/main.js"></script>
@endpush
@endsection