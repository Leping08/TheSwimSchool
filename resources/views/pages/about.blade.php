@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Swim Lessons | Ellenton Swimming Classes | The Swim School</title>
    <meta name="description" content="The Swim School near Parrish & Ellenton is proud to offer private and semi-private swim lessons, as well as group swimming classes! Visit our website for more information."/>
@endsection

@section('heading')
About The Swim School
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-flex-middle uk-grid-large uk-grid">
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="{{ asset('/img/lessons/kids-floating.jpg') }}" class="el-image uk-border-rounded uk-box-shadow-large" alt="Parrish Children's swim lessons">
                </div>
            </div>
            <div class="uk-width-expand@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium uk-margin-top">History</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium">
                <div class="uk-margin uk-dropcap">
                    <p>
                        In May 2015, The Swim School began offering <a title="Private Swim Lessons Parrish" href="{{ route('private_lesson.index') }}">private</a> and <a title="Group Swimming Parrish" href="{{ route('groups.lessons.index') }}">group swim lessons</a> in Manatee County for adults and children 6 months of age and older. In addition to providing quality stroke instruction for all ability levels, The Swim School expanded their services and started the <a title="Youth Swim Team near Ellenton" href="{{ route('swim-team.index') }}">{{ config('swim-team.full-name') }}</a> in May 2018, a seasonal program for youth ages 5-18.
                    </p>
                </div>
            </div>
        </div>

        @foreach ($instructors as $instructor)
            <div id="{{ $instructor->name }}" class="uk-flex-middle uk-grid-large uk-grid">
                @if ($instructor->image_url)
                    <div class="uk-width-expand@m">
                        <div class="uk-margin">
                            <img src="https://theswimschool-bucket.s3.amazonaws.com/tmp/{{$instructor->image_url}}" class="el-image uk-border-rounded uk-box-shadow-large" alt="{{ $instructor->name }}">
                        </div>
                    </div>
                @endif
                <div class="uk-width-expand@m {{ $loop->even ? '' : 'uk-flex-first@m' }} uk-first-column">
                     <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium uk-margin-top">{{ $instructor->name }}</h2>
                     <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium">
                     <div class="uk-margin uk-dropcap">
                         <p>
                            {{ $instructor->bio }}
                         </p>
                         {{-- <div class="uk-margin-bottom">
                             <a title="Parrish Swim School" class="uk-button uk-button-secondary" href="tel:+12078314179"><span uk-icon="icon: receiver" class=""></span> (207) 831-4179</a>
                         </div> --}}
                     </div>
                 </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

