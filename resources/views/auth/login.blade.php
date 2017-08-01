@extends('layouts.app-uikit')

@section('heading')
Admin Login
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-first-column">
                <div class="uk-card uk-card-default uk-card-body">
                    <form class="uk-form-stacked" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="uk-margin {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="uk-form-label uk-heading-bullet">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="uk-margin {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="uk-form-label uk-heading-bullet">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="uk-input" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="uk-margin">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input class="uk-checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="uk-margin">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="uk-button uk-button-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
