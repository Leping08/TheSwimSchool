@extends('layouts.app-uikit')

@section('seo')
    <title>Group Swimming Lessons Schedule | Parrish Swim Classes | Bradenton</title>
    <meta name="description" content="Group swimming lessons are available for swimmers of all levels! Find our group lesson sessions and registration schedule for Parrish swim classes, near Bradenton and Ellenton. "/>
@endsection

@section('heading')
    Group Swim Lesson Session & Registration Schedule
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">
            <div>
                *Class days & times are subject to change per session and level based on facility and instructor availability, so the specific class day & times are not available until registration opens for each session. Registration is completed online through the “Levels” by clicking on the “Find Classes” button.
            </div>

            <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>2023 Winter & Spring Schedule</span></h2>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Weekday AM & PM Sessions (2x/wk for 4 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>January 9th - February 2nd</td>
                            <td>January 2nd</td>
                        </tr>
                        <tr>
                            <td>February 13th - March 9th</td>
                            <td>February 6th</td>
                        </tr>
                        <tr>
                            <td>March 20th - April 13th</td>
                            <td>March 13th</td>
                        </tr>
                        <tr>
                            <td>April 24th - May 18th</td>
                            <td>April 17th</td>
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
                            <td>January 14th - February 18th</td>
                            <td>January 2nd</td>
                        </tr>
                        <tr>
                            <td>February 25th - April 1st</td>
                            <td>February 20th</td>
                        </tr>
                        <tr>
                            <td>April 15th - May 20th</td>
                            <td>April 3rd</td>
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
                            <td>January 15th - February 19th</td>
                            <td>January 2nd</td>
                        </tr>
                        <tr>
                            <td>February 25th-April 1st</td>
                            <td>February 20th</td>
                        </tr>
                        <tr>
                            <td>April 16th - May 21st</td>
                            <td>April 3rd</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>2023 Summer Schedule</span></h2>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Weekday AM & PM Sessions (M/T/W/TH 4x/wk for 2 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>June 5th - June 15th</td>
                            <td>May 22nd</td>
                        </tr>
                        <tr>
                            <td>June 19th - June 29th</td>
                            <td>June 12th</td>
                        </tr>
                        <tr>
                            <td>July 10th - July 20th</td>
                            <td>July 3rd</td>
                        </tr>
                        <tr>
                            <td>July 24th - August 3rd</td>
                            <td>July 17th</td>
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
                            <td>June 3rd - July 8th</td>
                            <td>May 22nd</td>
                        </tr>
                        <tr>
                            <td>July 22nd - August 26th</td>
                            <td>July 10th</td>
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
                            <td>June 4th - July 9th</td>
                            <td>May 22nd</td>
                        </tr>
                        <tr>
                            <td>July 23rd - August 27th</td>
                            <td>July 10th</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- <div class="uk-margin-large-top">
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
                            <td>March 26th-May 7th **(No Class Easter Weekend 4/16)</td>
                            <td>March 7th</td>
                        </tr>
                        <tr>
                            <td>May 14th-June 25th **(No Class Memorial Day Weekend 5/28)</td>
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
                            <td>March 27th-May 8th **(No Class Easter Weekend 4/17)</td>
                            <td>March 7th</td>
                        </tr>
                        <tr>
                            <td>May 15th-June 26th **(No Class Memorial Day Weekend 5/29)</td>
                            <td>May 2nd</td>
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