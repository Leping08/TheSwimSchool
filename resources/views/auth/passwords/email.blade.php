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
                        <form class="uk-form-stacked" role="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="uk-margin">
                                <label for="email" class="uk-form-label uk-heading-bullet">E-Mail Address</label>
                                <input id="email" type="email" class="uk-input" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="uk-margin">
                                <button type="submit" class="uk-button uk-button-primary">
                                    Send Password Reset Link
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
