@extends('layouts.app-uikit')

@section('heading')
    Edit {{$group->type}}
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <form method="POST" action="/groups/{{{$group->id}}}" class="uk-form-stacked">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PATCH">
                        <h3 class="uk-heading-bullet uk-margin-remove-top">Lesson</h3>
                        <div class="uk-margin">
                            <label for="type"  class="uk-form-label">Lesson Name</label>
                            <input type="text" class="uk-input" id="type" name="type" placeholder="Type" value="{{ old('type') ?? $group->type }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="age"  class="uk-form-label">Lesson Age</label>
                            <input type="text" class="uk-input" id="ages" name="ages" placeholder="5-7 Years" value="{{ old('age') ?? $group->ages }}" required>
                        </div>
                        <div class="uk-margin">
                            <label for="description"  class="uk-form-label">Lesson Description</label>
                            <textarea class="uk-textarea" rows="5" id="description" name="description">{{ old('description') ?? $group->description }}</textarea>
                        </div>

                        <hr>

                        <div>
                            <button type="submit" class="uk-button uk-button-primary">Update</button>
                            <a href="/groups/{{$group->id}}" class="uk-button uk-button-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


