@extends('layouts.app-uikit')

@section('seo')
    <title>Group Swimming Lessons Schedule | Parrish Swim Classes | Bradenton</title>
    <meta name="description" content="Group swimming lessons are available for swimmers of all levels! Find our group lesson sessions and registration schedule for Parrish swim classes, near Bradenton and Ellenton. "/>
@endsection

@section('heading')
    Group Lesson Sessions & Registration Schedule
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div>
                <h2 class="uk-heading-line"><span>2022 Winter & Spring Schedule</span></h2>
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

            <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>2022 Summer Schedule</span></h2>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Weekday AM Sessions (M/T/W/TH 4x/wk for 2 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>June 6th-June 16th</td>
                            <td>May 23rd</td>
                        </tr>
                        <tr>
                            <td>June 20th-June 30th</td>
                            <td>June 13th</td>
                        </tr>
                        <tr>
                            <td>July 11th-July 21st</td>
                            <td>June 27th</td>
                        </tr>
                        <tr>
                            <td>July 25th-August 4th</td>
                            <td>July 18th</td>
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
                            <td>July 9th-August 13th</td>
                            <td>June 27th</td>
                        </tr>
                        <tr>
                            <td>August 20th-October 1st (No Classes Labor Day Weekend 9/3)</td>
                            <td>August 8th</td>
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
                            <td>July 10th-August 14th</td>
                            <td>June 27th</td>
                        </tr>
                        <tr>
                            <td>August 21st-October 2nd (No Classes Labor Day Weekend 9/4)</td>
                            <td>August 8th</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>Winter 2022 Sessions</span></h2>
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
            </div> --}}

            <p>*Class times vary per level and session based on facility and instructor availability, so the specific class
                times are not available until registration opens for each session. <a href="{{ route('groups.lessons.index') }}">Registration</a> is completed online
                through the “Levels” by clicking on the “Find Classes” button.</p>

        </div>
    </div>
@endsection