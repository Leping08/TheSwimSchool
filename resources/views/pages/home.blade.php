@extends('layouts.app-uikit')

@section('seo')
    <title>The Swim School | Parrish Swimming Lessons | Palmetto Ellenton</title>
    <meta name="description" content="Enjoy the convenience of private, semi-private, or small group swimming lessons for all ability levels with The Swim School! Serving Parrish, Bradenton, Ellenton and Palmetto."/>
@endsection

@section('heading')
    Home
@endsection

@section('content')
    <div id="page#1" class="uk-section-secondary uk-section-overlap">
        <div style="background-image: url({{asset('/img/theme/pool-water.jpg')}});" class="uk-background-norepeat uk-background-cover uk-background-bottom-center uk-background-fixed uk-section uk-padding-remove-vertical">
            <div class="uk-container">
                <div class="uk-grid-margin uk-grid-stack" uk-grid>
                    <div class="uk-width-1-1@m uk-first-column">
                        <h2 class="text-black uk-margin-remove-vertical uk-text-center uk-heading-primary uk-scrollspy-inview uk-animation-slide-top" uk-scrollspy-class="" style="font-family:sans-serif;">
                            The Swim School
                        </h2>
                        <div class="text-black uk-margin-small uk-text-center uk-text-lead uk-scrollspy-inview uk-animation-slide-bottom" uk-scrollspy-class="uk-animation-slide-bottom">
                            Taking School To The Pool
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="uk-section-muted uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid-stack" uk-grid>
                <div class="uk-width-1-1@m uk-first-column">
                    <h2 class="uk-text-center uk-h1 uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                        Services
                    </h2>
                    <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                </div>
            </div>
            <div class="uk-grid-margin" uk-grid>
                <div class="uk-width-expand@m uk-grid-item-match uk-first-column">
                    <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                        <a title="Swim Lesson Bradenton" href="{{ route('groups.lessons.index') }}" class="el-link uk-position-cover uk-position-z-index uk-margin-remove-adjacent"></a>
                        <div class="uk-card-media-top">
                            <img src="{{ asset('/img/lessons/group.jpg') }}" class="el-image uk-border-rounded" alt="Parrish children's swim lessons">
                        </div>
                        <div class="uk-card-body">
                            <h3 class="el-title uk-margin uk-h2 uk-heading-bullet">Group Lessons</h3>
                            <div class="el-content uk-margin">The Swim School features aquatics programs to meet the
                                specific needs of various age groups from beginner to advanced skill levels. Sessions of
                                small group classes are available for Parent & Infant/Toddler, Preschool and Youth/Teens.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand@m uk-grid-item-match">
                    <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                        <a title="Parrish private swim lessons" href="{{ route('private_lesson.index') }}" class="el-link uk-position-cover uk-position-z-index uk-margin-remove-adjacent"></a>
                        <div class="uk-card-media-top">
                            <img src="{{ asset('/img/lessons/private.jpg') }}" class="el-image uk-border-rounded" alt="Ellenton swimming lessons">
                        </div>
                        <div class="uk-card-body">
                            <h3 class="el-title uk-margin uk-h2 uk-heading-bullet">Private Lessons</h3>
                            <div class="el-content uk-margin">The Swim School offers individualized lessons available
                                to adults and children (12 months +) of all ability levels. Swim instruction is customized
                                to the needs and goals of each participant.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand@m uk-grid-item-match">
                    <div class="uk-margin uk-text-left@s uk-text-center uk-card uk-card-default uk-card-hover uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                        <a title="{{ config('swim-team.full-name') }}" href="{{ route('swim-team.index') }}" class="el-link uk-position-cover uk-position-z-index uk-margin-remove-adjacent"></a>
                        <div class="uk-card-media-top">
                            <img src="{{ asset('/img/swim-team/dive-cropped.jpg') }}" class="el-image uk-border-rounded" alt="{{ config('swim-team.full-name') }}">
                        </div>
                        <div class="uk-card-body">
                            <h3 class="el-title uk-margin uk-h2 uk-heading-bullet">Swim Team</h3>
                            <div class="el-content uk-margin">Love to swim? Join the {{ config('swim-team.full-name') }},
                                a seasonal program run by The Swim School. Quality level coaches provide a fun atmosphere
                                for children ages 5-18 to improve their technique of the four competitive strokes, build
                                endurance and learn about sportsmanship through local competition.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-flex">
                <div class="uk-width-1-1">
                    <h2 class="uk-text-center uk-h1">
                        Testimonials
                    </h2>
                    <hr class="uk-divider-icon">
                </div>
            </div>

            <div uk-slider="autoplay: true; autoplay-interval: 6000">
                <div class="uk-position-relative uk-visible-toggle uk-dark" tabindex="-1">
                    <ul class="uk-slider-items uk-child-width-1-3@s" uk-grid uk-height-match="target: > li > .uk-card">
                        @foreach($reviews as $review)
                            <li>
                                <div class="uk-card uk-card-default uk-card-secondary">
                                    <div class="uk-card-body">
                                        <h3 class="uk-margin uk-h3">{{\Carbon\Carbon::parse($review->created_time)->toDateString()}}</h3>
                                        <p>{{$review->short_message}}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            </div>
        </div>
    </div>
@endsection

