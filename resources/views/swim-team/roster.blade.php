@extends('layouts.app-uikit')

@section('seo')
    <!-- TODO: SEO swim team roster page -->
    <title></title>
    <meta name="description" content=""/>
@endsection

@section('heading')
    North River Swim Team Roster
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                    @foreach($levels as $level)
                        <h2 class="uk-heading-line"><span>{{$level->name}} ({{$level->swimmers->count()}})</span></h2>
                        <div class="uk-overflow-auto">
                            <table class="uk-table uk-table-striped uk-table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Date Of Birth</th>
                                        <th>Years Old</th>
                                        <th>Email</th>
                                        <th>Emergency Contact Name</th>
                                        <th>Emergency Contact Phone</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($level->swimmers as $swimmer)
                                    <tr>
                                        <td>{{$swimmer->firstName}} {{$swimmer->lastName}}</td>
                                        <td>{{$swimmer->phone}}</td>
                                        <td>{{$swimmer->birthDate->format('m/d/y')}}</td>
                                        <td>{{$swimmer->yearsOld()}}</td>
                                        <td>{{$swimmer->email}}</td>
                                        <td>{{$swimmer->emergencyName}}</td>
                                        <td>{{$swimmer->emergencyPhone}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

