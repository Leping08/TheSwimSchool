@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Group Lessons | Bradenton Swimming Classes | Sun City Center</title>
    <meta name="description" content="Interested in Parrish group lessons? Sign up for our Bradenton swimming classes today by choosing your child's age and swimming lesson."/>
@endsection

@section('heading')
Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-child-width-expand uk-grid-collapse uk-grid-match uk-flex-middle uk-grid" uk-grid>
                <div class="uk-width-1-4@m">
                    <div class="uk-card-media-left">
                        <div class="uk-flex uk-flex-center uk-text-center">
                            <div>
                                <img alt="Swim Lessons" class="uk-width-3-4" src="{{asset($group->iconPath)}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="uk-card-body">
                        <h2 class="uk-margin uk-h2 uk-margin-remove-adjacent">{{$group->type}}</h2>
                        <div class="uk-margin uk-text-meta uk-text-primary">{{$group->ages}}</div>
                        <div class="uk-margin">{{$group->description}}</div>
                    </div>
                </div>
            </div>
            <!-- If active lessons exist display them -->
            @if(count($group->lessons()->registrationOpen()->get()))
                @foreach($group->lessons()->registrationOpen()->get() as $lesson)
                    <div class="uk-card uk-card-default uk-margin-top">
                        <div class="uk-card-header">
                            <div class="uk-card-title f-24 uk-heading-bullet">
                                @foreach($lesson->DaysOfTheWeek as $day)
                                    {{$day->day}}@if(!$loop->last) & @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="uk-card-body">
                            <div class="uk-child-width-expand@s" uk-grid>
                                <div><i class="fa fa-users fa-lg" aria-hidden="true"></i> <strong>Class Size:</strong> {{$lesson->class_size}}</div>
                                <div><i class="fa fa-user fa-lg" aria-hidden="true"></i> <strong>Spots Remaining:</strong> {{$lesson->class_size - $lesson->swimmers->count()}}</div>
                            </div>
                            
                            <div class="uk-child-width-expand@s" uk-grid>
                                <div><i class="fa fa-graduation-cap fa-lg" aria-hidden="true"></i> <strong>Instructor:</strong> <a href="{{ route('pages.about') . '#'. $lesson->instructor->name }}">{{$lesson->instructor->name}}</a></div>
                                <div><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <strong>Dates:</strong> {{$lesson->class_start_date->toFormattedDateString()}} - {{$lesson->class_end_date->toFormattedDateString()}}</div>
                            </div>
                            
                            <div class="uk-child-width-expand@s" uk-grid>
                                <div><i class="fa fa-map-marker fa-lg" aria-hidden="true"></i> <strong>Location:</strong> {{$lesson->location->name}}<br><a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{{$lesson->location->street}}}+{{{$lesson->location->city}}}+{{{$lesson->location->state}}}+{{{$lesson->location->zip}}}">{{$lesson->location->street}}, <br>{{$lesson->location->city}}, {{$lesson->location->state}} {{$lesson->location->zip}}</a></div>
                                <div><i class="fa fa-clock-o fa-lg" aria-hidden="true"></i> <strong>Times:</strong><br>
                                    @foreach($lesson->DaysOfTheWeek as $day)
                                    {{$day->day}} {{$lesson->class_start_time->format('g:i a')}} - {{$lesson->class_end_time->format('g:i a')}}<br>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="uk-child-width-expand@s" uk-grid>
                                <div><i class="fa fa-money fa-lg" aria-hidden="true"></i> <strong>Price:</strong> ${{$lesson->price}}</div>
                            </div>

                            @if (Auth::guest())

                            @else
                                <ul class="uk-list uk-list-striped">
                                    <li><strong>Swimmers</strong></li>
                                    @foreach($lesson->swimmers as $swimmer)
                                        <li><a href="/admin/resources/swimmers/{{{$swimmer->id}}}" class="list-group-item list-group-item-action justify-content-between">
                                            {{$swimmer->firstName}} {{$swimmer->lastName}}
                                        </a></li>
                                    @endforeach
                                </ul>
                            @endif

                            @if($lesson->class_size - $lesson->swimmers->count() > 0)

                            @else
                                <p><b>This class is full. We recommend signing up for a different class with openings. If you choose to join the wait list, we will notify you if any spots become available within 24-48 hours of the session start date.</b></p>
                            @endif
                        </div>
                        <div class="uk-card-footer">
                            @if($lesson->class_size - $lesson->swimmers->count() > 0)
                                <a href="{{ route('groups.lessons.create', [$group, $lesson]) }}" class="uk-button uk-button-primary">Sign Up</a>
                            @else
                                <button class="uk-button uk-button-primary" uk-toggle="target: #wait-list-{{{$lesson->id}}}">Join Wait List</button>
                            @endif
                        </div>
                    </div>

                    <!-- This is the wait list modal -->
                    <div id="wait-list-{{{$lesson->id}}}" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body uk-card uk-card-default uk-padding-remove">
                            <div class="uk-card-header">
                                <div class="uk-card-title f-24">Join the Wait List</div>
                            </div>
                            <form action="{{ route('groups.lessons.wait-list', [$lesson]) }}" method="POST">
                                {{ csrf_field() }}
                                <div class="uk-card-body">
                                    <p>Be the first to know if any spots open up for this class.</p>
                                    <div class="uk-grid-small" uk-grid>
                                        <div class="uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="name">Swimmer Name</label>
                                            <div class="uk-form-controls">
                                                <input type="text" class="uk-input" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="date_of_birth">Swimmer Birth Date</label>
                                            <div class="uk-form-controls">
                                                <input type="date" class="uk-input" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="email">Email</label>
                                            <div class="uk-form-controls">
                                                <input type="text" class="uk-input" id="email" name="email" placeholder="email@gmail.com" value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                        <div class="uk-width-1-1@s">
                                            <label class="uk-form-label uk-heading-bullet" for="phone">Phone</label>
                                            <input type="tel" id="phone" name="phone" placeholder="999-123-4567" class="uk-input" value="{{ old('phone') }}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-text-right uk-card-footer">
                                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
                                    <button class="uk-button uk-button-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            <!-- No active lessons exist so display no classes -->
            @else
                <div class="uk-section-default uk-section-overlap uk-section">
                    <div class="uk-container">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <h3 class="uk-heading-bullet f-24">No Classes Available At This Time</h3>
{{--                                <h3 class="uk-heading-bullet f-24">We are now closed for the 2020 season</h3>--}}
                            </div>
                            <div class="uk-card-body">
                                <div class="card-text">
                                    <p>Check out the <a title="{{ config('swim-team.full-name') }}" href="{{ route('groups.schedule.index') }}">Group Lesson Sessions & Registration Schedule</a> to find out when our next session registration will be available.</p>
                                </div>
{{--                                <div class="card-text">--}}
{{--                                    <p>Registration will open for our next session of swim lessons {{config('season.groups.next_season.registration_open')}}. Please check back at another time.<br>--}}
{{--                                    In the mean time check out our <a title="{{ config('swim-team.full-name') }}" href="{{ route('swim-team.index') }}">swim team</a> or ask about <a title="Parrish Private Swim Lessons" href="{{ route('private_lesson.index') }}">private lessons</a>.</p>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

