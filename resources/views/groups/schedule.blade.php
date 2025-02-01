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
                *Class days & times are subject to change per session and level based on facility and instructor availability, so the specic class days & times are not available until registration opens for each session. Registration is completed online through the “Levels” by clicking on the “Find Classes” button.
            </div>

            <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>2024-2025 School Year Weekday Schedule</span></h2>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Fall Weekday AM & PM Sessions (2x/wk for 4 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>August 19th-September 17th <br>**(No Classes Thurs 8/29; Makeup Tues 9/17) <br>**(No Classes Labor Day Mon 9/2; Makeup Mon 9/16)</td>
                            <td>August 5th</td>
                        </tr>
                        <tr>
                            <td>September 23rd-October 24th <br>(Hurricane Makeup Days 10/21-10/24)</td>
                            <td>September 16th</td>
                        </tr>
                        <tr>
                            <td>October 28th-November 26th <br>**(No Classes Halloween Thurs 10/31; Makeup Tues 11/26) <br>**(No Classes Veterans Day Mon 11/11; Makeup Mon 11/25)</td>
                            <td>October 21st</td>
                        </tr>
                    </tbody>
                </table>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Winter Weekday PM Sessions (2x/wk for 4 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>January 6th-February 3rd <br>**(No Classes MLK Jr. Day Mon 1/20; Makeup Mon 2/3)</td>
                            <td>December 23rd</td>
                        </tr>
                        <tr>
                            <td>February 10th-March 10th <br>**(No Classes Presidents Day Mon 2/17; Makeup Mon 3/10)</td>
                            <td>February 3rd</td>
                        </tr>
                    </tbody>
                </table>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Spring Weekday AM & PM Sessions (2x/wk for 4 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>March 24th-April 17th</td>
                            <td>March 10th</td>
                        </tr>
                        <tr>
                            <td>April 21st-May 15th</td>
                            <td>April 14th</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>2024-2025 Weekend Schedule</span></h2>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Saturday AM Sessions (1x/wk for 6 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>July 20th-August 24th</td>
                            <td>July 8th</td>
                        </tr>
                        <tr>
                            <td>September 7th-October 12th</td>
                            <td>August 26th</td>
                        </tr>
                        <tr>
                            <td>October 19th-November 23rd</td>
                            <td>October 14th</td>
                        </tr>
                        <tr>
                            <td>January 4th-February 8th</td>
                            <td>December 23rd</td>
                        </tr>
                        <tr>
                            <td>February 15th-March 22nd</td>
                            <td>February 10th</td>
                        </tr>
                        <tr>
                            <td>April 5th-May 17th <br>**(No Classes Easter Weekend Sat 4/19; Makeup Sat 5/17)</td>
                            <td>March 24th</td>
                        </tr>
                        <tr>
                            <td>June 7th-July 19th <br>**(No Classes Independence Day Weekend Sat 7/5; Makeup Sat 7/19)</td>
                            <td>May 19th</td>
                        </tr>
                    </tbody>
                </table>

                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Sunday AM Sessions (1x/wk for 6 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>July 21st-August 25th</td>
                            <td>July 8th</td>
                        </tr>
                        <tr>
                            <td>September 8th-October 13th</td>
                            <td>August 26th</td>
                        </tr>
                        <tr>
                            <td>October 20th-November 24th</td>
                            <td>October 14th</td>
                        </tr>
                        <tr>
                            <td>January 5th-February 16th</td>
                            <td>December 23rd</td>
                        </tr>
                        <tr>
                            <td>February 23rd-March 30th</td>
                            <td>February 17th</td>
                        </tr>
                        <tr>
                            <td>April 6th-May 18th <br>**(No Classes Easter Weekend Sun 4/20; Makeup Sun 5/18)</td>
                            <td>March 24th</td>
                        </tr>
                        <tr>
                            <td>June 8th-July 20th <br>**(No Classes Independence Day Weekend Sun 7/6; Makeup Sun 7/20)</td>
                            <td>May 19th</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="uk-margin-large-top">
                <h2 class="uk-heading-line"><span>2025 Summer Weekday Schedule</span></h2>
                <table class="uk-table uk-table-striped">
                    <thead>
                        <tr>
                            <th class="uk-width-1-2"><h5>Weekday AM & PM Sessions (M/T/W/TH 4x/wk for 2 weeks)</h5></th>
                            <th class="uk-width-1-2"><h5>Registration Opens</h5></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>June 2nd-June 12th</td>
                            <td>May 19th</td>
                        </tr>
                        <tr>
                            <td>June 16th-June 26th</td>
                            <td>June 9th</td>
                        </tr>
                        <tr>
                            <td>June 30th-July 10th</td>
                            <td>June 23rd</td>
                        </tr>
                        <tr>
                            <td>July 14th-July 24th</td>
                            <td>July 7th</td>
                        </tr>
                        <tr>
                            <td>July 28th-August 7th</td>
                            <td>July 21st</td>
                        </tr>
                    </tbody>
                </table>

            </div>

            <p>*Class times vary per level and session based on facility and instructor availability, so the specific class
                times are not available until registration opens for each session. <a href="{{ route('groups.lessons.index') }}">Registration</a> is completed online
                through the “Levels” by clicking on the “Find Classes” button.</p>

        </div>
    </div>
@endsection
