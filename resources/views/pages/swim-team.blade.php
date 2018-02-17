@extends('layouts.app-uikit')

@section('seo')
    <title>North River Swim Team</title>
    <meta name="description" content="Meta Here."/>
@endsection

@section('heading')
    North River Swim Team
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-expand@m uk-first-column">
                    <div class="uk-dropcap">
                        <p>Bring your suit, goggles & towel and come join our team! The North River Swim Team is holding tryouts at the River Wilderness Country Club. Registration for pre-season tryouts opens April 1st, 2018.</p>
                    </div>
                    <div>
                        <h3 class="uk-heading-line"><span>2018 Pre-Season Tryout Dates</span></h3>
                        <ul class="uk-list uk-list-bullet">
                            <li>Wed. 4/18 6:30PM</li>
                            <li>Thurs. 4/19 6:30PM</li>
                            <li>Sat. 4/21 10:00AM</li>
                        </ul>
                    </div>
                    <div>
                        <p>The North River Swim Team practices at the River Wilderness Country Club and competes in the Suncoast Swim League, a seasonal developmental league that runs May 1st - August 31st.</p>
                    </div>
                    <div>
                        <a class="uk-button uk-button-default" disabled> Registration Coming Soon</a>
                    </div>
                </div>
                <div class="uk-width-expand@m">
                    <div class="uk-margin">
                        <img src="/img/private-lessons.jpg" class="el-image" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

