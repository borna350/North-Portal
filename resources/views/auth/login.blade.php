<body id="page-top">

<!-- Navigation -->
@include('head')
<header class="masthead">
    <div class="logo">
        <div class="container-fluid">
            <img src="{{asset('img/logow.png')}}" alt="">
        </div>
    </div>
    <img src="{{asset('img/loginbg.jpg')}}" class="bg" alt="">
    <div class="container login">
        <div class="intro-text">
            <div class="log">Login</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                    @enderror

                </div>
                <div class="form-group">
                    <label for="pwd">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                    @enderror
                </div>
                <div class="form-group form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
                <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            </form>
        </div>
    </div>
</header>
</body>
