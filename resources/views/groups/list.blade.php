@extends('layouts.app-uikit')

@section('seo')
    <title>Group Swim Lessons | Parrish Swimming Classes | The Swim School Florida</title>
    <meta name="description" content="Group swim lessons are available for swimmers of all levels! From infants to advanced youth, The Swim School near Parrish Florida is available for everyone. Sign up online today!"/>
@endsection

@section('heading')
    Group Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            @if($banner && $banner->active)
                <div class="uk-alert-primary" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    {!! $banner->text !!}
                </div>
            @endif

            <div class="uk-width-1-1@m uk-first-column uk-margin-top">
                <h2 class="uk-heading-line"><span>Locations</span></h2>
                <p>Group Lessons take place at two different locations. Realhab Physical Therapy and Lincoln Aquatic Center.</p>
                <div class="uk-grid-small uk-grid-match uk-child-width-expand@s uk-grid">
                    <div class="uk-first-column">
                        <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                            <h5>Realhab Physical Therapy</h5>
                            <ul class="uk-list uk-list-bullet">
                                <li>Weekday AM & PM and Weekend AM lessons</li>
                                <li>Heated pool</li>
                                <li>Year Round</li>
                                <li>Indoor</li>
                            </ul>
                            <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Realhab&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div>
                        <div class="uk-card uk-card-default uk-card-body uk-margin-top">
                            <h5>Lincoln Aquatic Center</h5>
                            <ul class="uk-list uk-list-bullet">
                                <li>Weekday AM lessons</li>
                                <li>Heated pool</li>
                                <li>Seasonal</li>
                                <li>Outdoor</li>
                            </ul>
                            <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Lincoln_Aquatic_Center&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>


            <div class="uk-section-default uk-section-overlap uk-section">
                <div class="uk-container">
                    <div>
                        <h2 class="uk-heading-line"><span>Session & Registration Schedule</span></h2>

                        <p>Class times vary per level and session based on facility and instructor availability, so the specific class times are not available until registration opens for each session. Once registration opens, it is completed online through the Levels by clicking on the “Find Classes” button.</p>

                        <p><a title="Group Swimming Lessons Schedule" class="uk-button uk-button-primary" href="{{ route('groups.schedule.index') }}">Registration Schedule</a></p>
                    </div>
                </div>
            </div>
            

            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-4-4@m uk-first-column">
                    <h2 class="uk-heading-line"><span>Pricing</span></h2>
                    <div class="uk-grid-small uk-grid-match uk-child-width-expand@s" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekday Session 8-30 Min Classes ($20.00 Per Class)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>$160 Per Session</li>
                                    <li>No Registration Fees</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekend Session 6-30 Min Classes ($20.00 Per Class)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>$120 Per Session</li>
                                    <li>No Registration Fees</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="uk-width-1-1@m uk-first-column">
                <h2 class="uk-heading-line"><span>Levels</span></h2>
                <div class="uk-grid-small uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@lg" uk-grid>
                    @forelse($groups as $group)
                        <div class="">
                            <div class="uk-margin uk-text-center uk-card uk-card-default uk-card-body uk-scrollspy-inview uk-animation-fade" uk-scrollspy-class="uk-animation-fade">
                                <img class="uk-width-1-2" alt="" src="{{ asset($group->iconPath) }}">
                                <h2 class="uk-margin uk-h3">{{$group->type}}</h2>
                                <p class="uk-text-meta uk-text-primary">{{$group->ages}}</p>
                                <div class="uk-margin">{{\Illuminate\Support\Str::limit($group->description, 350)}}</div>
                                <p><a title="Group Swimming Lessons Parrish" class="uk-button uk-button-primary" href="{{ route('groups.lessons.show', [$group]) }}">Find Classes</a></p>
                            </div>
                        </div>
                    @empty
                        <div class="">
                            <div class="uk-margin uk-text-center uk-card uk-card-default uk-card-body">
                                <h2 class="uk-margin uk-h3">No levels available at this time.</h2>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
