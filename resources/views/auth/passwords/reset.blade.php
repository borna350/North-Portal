

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
                <div class="log">Reset Password</div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                   
                    <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>

                           
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>

                           
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>

                           
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                           
                        </div>
                    
                    <button style="padding: 6px 40px;" type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
                    
                </form>
            </div>
        </div>
    </header>
    
    </body>