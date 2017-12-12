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

                        <div class="uk-margin">
                            <label for="email" class="uk-form-label uk-heading-bullet">E-Mail Address</label>
                            <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="uk-margin">
                            <label for="password" class="uk-form-label uk-heading-bullet">Password</label>
                            <input id="password" type="password" class="uk-input" name="password" required>
                        </div>

                        <div class="uk-margin">
                            <label>
                                <input class="uk-checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>

                        <div class="uk-margin">
                            <button type="submit" class="uk-button uk-button-primary">
                                Login
                            </button>

                            <a class="uk-button uk-button-secondary" href="{{ route('password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
