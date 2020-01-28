<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="{{ URL::to('/index') }}">Food<span style="color: #3CB371;">Recipe.</span></a>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('/index') }}">ホーム</a>
        </li>
        @if(Auth::check())
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('/inputform') }}">レシピ投稿</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            こんにちは、{{Auth::user()->nickname}}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
            <a class="dropdown-item" href="{{ URL::to('/logout') }}">ログアウト</a>
          </div>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('/login') }}">ログイン</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ URL::to('/register') }}">サインアップ</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>