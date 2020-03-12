<body id="page-top">
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
            <div class="log">Reset Password</div>
            <form method="POST" action="{{ route('password.email') }}">
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
                
                <button type="submit" class="btn btn-primary">{{ __('Send Password Reset Link') }}</button>
                
            </form>
        </div>
    </div>
</header>
</body>