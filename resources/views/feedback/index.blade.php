@extends('layouts.app-uikit')

@section('seo')
    {{--TODO: SEO this page--}}
    <title></title>
    <meta name="description" content=""/>
@endsection

@section('heading')
    Feedback
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-card uk-card-default uk-margin-top">
                <div class="uk-card-header">
                    <div class="uk-h2 uk-heading-bullet uk-margin uk-width-1-1 uk-margin-remove-top">
                        Feedback Survey
                    </div>
                </div>
                <div class="uk-card-body">
                    <form class="uk-grid-small" uk-grid action="" method="POST">
                        {{ csrf_field() }}
                        <p class="uk-margin-medium-bottom">Thank you for participating in an aquatics program through The Swim School! To help us serve you better and improve our programs, we need your feedback. Please take a few minutes to complete this evaluation form regarding your recent experience with The Swim School. Thank You!</p>
                        <div uk-grid>

                            <div class="uk-width-1-1@s">
                                <b>On a scale of 1-5 with 5 being the best, please rate the following:</b>
                            </div>

                            <div class="uk-width-1-1@s">
                                <div style="font-size: 22px" class="uk-h3 uk-margin uk-heading-line uk-width-1-1 uk-margin-medium-top">
                                    Instructor
                                </div>
                            </div>
                            @foreach($questions as  $index => $question)
                                @if($question->type->id == 1 && $question->category->id == 1)
                                    <div class="uk-width-1-2@m uk-width-1-1@s">
                                        <div class="uk-margin uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="{{$question->id}}">{{$question->question}}</label>
                                            <select id="{{$question->id}}" name="question_{{$question->id}}" class="uk-select" required>
                                                <option value="" selected disabled hidden>--</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            @endforeach


                            <div class="uk-width-1-1@s">
                                <div style="font-size: 22px" class="uk-h3 uk-margin uk-heading-line uk-width-1-1 uk-margin-medium-top">
                                    Overall Program
                                </div>
                            </div>
                            @foreach($questions as  $index => $question)
                                @if($question->type->id == 1 && $question->category->id == 2)
                                    <div class="uk-width-1-2@m uk-width-1-1@s">
                                        <div class="uk-margin uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="{{$question->id}}">{{$question->question}}</label>
                                            <select id="{{$question->id}}" name="question_{{$question->id}}" class="uk-select" required>
                                                <option value="" selected disabled hidden>--</option>
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            @endforeach


                            <div class="uk-width-1-1@s">
                                <div style="font-size: 22px" class="uk-h3 uk-margin uk-heading-line uk-width-1-1 uk-margin-medium-top">
                                    Summary
                                </div>
                            </div>
                            @foreach($questions as  $index => $question)
                                @if($question->type->id == 2)
                                    <div class="uk-width-1-1@xs">
                                        <div class="uk-margin uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="{{$question->id}}">{{$question->question}}</label>
                                            <div class="uk-form-controls">
                                                <textarea class="uk-textarea" rows="3" id="{{$question->id}}" name="question_{{$question->id}}">{{ old('question_'.$question->id) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="uk-margin uk-width-1-1@s">
                            <button type="submit" class="uk-button uk-button-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

