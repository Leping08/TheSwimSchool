@extends('layouts.app-uikit')

@section('heading')
    Reset Password
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-expand@m uk-first-column">
                    <div class="uk-card uk-card-default uk-card-body">
                        <form class="uk-form-stacked" role="form" method="POST" action="{{ route('password.request') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="uk-margin">
                                <label for="email" class="uk-form-label uk-heading-bullet">E-Mail Address</label>
                                <input id="email" type="email" class="uk-input" name="email" value="{{ $email or old('email') }}" required autofocus>
                            </div>

                            <div class="uk-margin">
                                <label for="password" class="uk-form-label uk-heading-bullet">Password</label>
                                <input id="password" type="password" class="uk-input" name="password" required>
                            </div>

                            <div class="uk-margin">
                                <label for="password-confirm" class="uk-form-label uk-heading-bullet">Confirm Password</label>
                                <input id="password-confirm" type="password" class="uk-input" name="password_confirmation" required>
                            </div>

                            <div class="uk-margin">
                                <button type="submit" class="uk-button uk-button-primary">
                                    Reset Password
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
