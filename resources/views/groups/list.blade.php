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
                <h2 class="uk-heading-line"><span>Location</span></h2>
                <p>Group Lessons take place year-round in an indoor, heated pool at Realhab Physical Therapy, Aquatics & Wellness Center located at 12159 US-301 N, Parrish, FL 34219.</p>
                <div class="uk-card uk-card-default">
                    <iframe height="300" class="uk-width-1-1" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=Realhab&key={{config('google.maps.api_key')}}&zoom=12" allowfullscreen></iframe>
                </div>
            </div>

            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-4-4@m uk-first-column">
                    <h2 class="uk-heading-line"><span>Pricing</span></h2>
                    <div class="uk-grid-small uk-grid-match uk-child-width-expand@s" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekday Session 8-30 Min Classes ($15.00 Per Class)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>$120 Per Session</li>
                                    <li>No Registration Fees</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <h5>Weekend Session 6-30 Min Classes ($15.00 Per Class)</h5>
                                <ul class="uk-list uk-list-bullet">
                                    <li>$90 Per Session</li>
                                    <li>No Registration Fees</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="uk-section-default uk-section-overlap uk-section">
                <div class="uk-container">
                    <div>
                        <h2 class="uk-heading-line"><span>Spring Schedule</span></h2>

                        <div class="uk-card uk-card-default uk-card-body">
                            <table class="uk-table uk-table-striped">
                                <thead>
                                    <tr>
                                        <th class="uk-width-1-2"><h5>Weekday AM & PM Sessions (M/W 2x/wk for 4 weeks)</h5></th>
                                        <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>January 17th-February 9th</td>
                                        <td>January 3rd</td>
                                    </tr>
                                    <tr>
                                        <td>February 14th-March 9th</td>
                                        <td>February 7th</td>
                                    </tr>
                                    <tr>
                                        <td>March 21st-April 13th</td>
                                        <td>March 7th</td>
                                    </tr>
                                    <tr>
                                        <td>April 25th-May 18th</td>
                                        <td>April 11th</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        
                        <hr>
        
                        <div class="uk-card uk-card-default uk-card-body">
                            <table class="uk-table uk-table-striped">
                                <thead>
                                    <tr>
                                        <th class="uk-width-1-2"><h5>Saturday AM Sessions (1x/wk for 6 weeks)</h5></th>
                                        <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>January 29th-March 5th</td>
                                        <td>January 10th</td>
                                    </tr>
                                    <tr>
                                        <td>March 26th-May 7th (No Class Easter Weekend 4/16)</td>
                                        <td>March 7th</td>
                                    </tr>
                                    <tr>
                                        <td>May 14th-June 25th (No Class Memorial Day Weekend 5/28)</td>
                                        <td>May 2nd</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
        
                        <hr>
        
                        <div class="uk-card uk-card-default uk-card-body">
                            <table class="uk-table uk-table-striped">
                                <thead>
                                    <tr>
                                        <th class="uk-width-1-2"><h5>Sunday AM Sessions (1x/wk for 6 weeks)</h5></th>
                                        <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>January 30th-March 6th</td>
                                        <td>January 10th</td>
                                    </tr>
                                    <tr>
                                        <td>March 27th-May 8th (No Class Easter Weekend 4/17)</td>
                                        <td>March 7th</td>
                                    </tr>
                                    <tr>
                                        <td>May 15th-June 26th (No Class Memorial Day Weekend 5/29)</td>
                                        <td>May 2nd</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
        
                    {{-- <p>*Class times vary per level and session so the specific class times are not available until registration opens for each session.</p>
        
                    <div class="uk-margin-large-top">
                        <h2 class="uk-heading-line"><span>Summer 2021 Sessions</span></h2>
                        <table class="uk-table uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-2"><h5>Weekday AM Sessions (M/T/W/TH 4x/wk for 2 weeks)</h5></th>
                                    <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>June 7th-June 17th</td>
                                    <td>May 31st</td>
                                </tr>
                                <tr>
                                    <td>June 21st-July 1st</td>
                                    <td>June 14th</td>
                                </tr>
                                <tr>
                                    <td>July 5th-July 15th</td>
                                    <td>June 28th</td>
                                </tr>
                                <tr>
                                    <td>July 19th-July 29th</td>
                                    <td>July 12th</td>
                                </tr>
                            </tbody>
                        </table>
        
                        <hr>
        
                        <table class="uk-table uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-2"><h5>Saturday AM Sessions (1x/wk for 6 weeks)</h5></th>
                                    <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>June 5th-July 17th (No Class July 3rd)</td>
                                    <td>May 17th</td>
                                </tr>
                                <tr>
                                    <td>July 24th-August 28th</td>
                                    <td>July 12th</td>
                                </tr>
                            </tbody>
                        </table>
        
                        <hr>
        
                        <table class="uk-table uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-2"><h5>Sunday AM Sessions (1x/wk for 6 weeks)</h5></th>
                                    <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>June 6th-July 18th (No Class July 4th)</td>
                                    <td>May 17th</td>
                                </tr>
                                <tr>
                                    <td>July 25th-August 29th</td>
                                    <td>July 12th</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
        
                    <p>*Class times vary per level and session so the specific class times are not available until registration opens for each session.</p>
        
                    <div class="uk-margin-large-top">
                        <h2 class="uk-heading-line"><span>Fall 2021 Sessions</span></h2>
                        <table class="uk-table uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-2"><h5>Weekday AM & PM Sessions (M/W; T/TH 2x/wk for 4 weeks)</h5></th>
                                    <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>August 9th-September 2nd</td>
                                    <td>August 2nd</td>
                                </tr>
                                <tr>
                                    <td>September 13th-October 7th</td>
                                    <td>September 6th</td>
                                </tr>
                                <tr>
                                    <td>October 11th-November 4th</td>
                                    <td>October 4th</td>
                                </tr>
                            </tbody>
                        </table>
        
                        <hr>
        
                        <table class="uk-table uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-2"><h5>Saturday AM Sessions (1x/wk for 6 weeks)</h5></th>
                                    <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>September 11th-October 16th</td>
                                    <td>August 30th</td>
                                </tr>
                            </tbody>
                        </table>
        
                        <hr>
        
                        <table class="uk-table uk-table-striped">
                            <thead>
                                <tr>
                                    <th class="uk-width-1-2"><h5>Sunday AM Sessions (1x/wk for 6 weeks)</h5></th>
                                    <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>September 12th-October 17th</td>
                                    <td>August 30th</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
        
                    <p>*Class times vary per level and session so the specific class times are not available until registration opens for each session.</p> --}}
        
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
