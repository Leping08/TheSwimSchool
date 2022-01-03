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

            <p>*Class times vary per level and session so the specific class times are not available until registration opens for each session.</p>

            {{-- <div class="uk-margin-large-top">
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
@endsection