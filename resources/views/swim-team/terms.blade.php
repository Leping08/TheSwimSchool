@extends('layouts.app-uikit')

@section('seo')
    <title>The {{ config('swim-team.full-name') }} | Policies and Procedures | Parrish</title>
    <meta name="description" content="In order to be on The {{ config('swim-team.full-name') }}, The Swim School requests that you read and follow the Policies and Procedures listed here. Contact us with any questions."/>
@endsection

@section('heading')
    The {{ config('swim-team.full-name') }} Policies & Procedures
@endsection

@section('content')
    <div class="uk-section-default uk-section-overlap uk-section">
        <div class="uk-container">

            <dl class="uk-description-list uk-description-list-divider">

                <dt>Liability:</dt>
                <dd>The enrolled participant and/or the parent/guardian of the participant recognize and understand that swimming is a Physical activity. In such there are risks inherent in the instruction and sport of swimming including but not limited to paralyzing injuries and the possibility of death. The participant hereby agrees to participate in the Parrish Bull Sharks Swim Team, a program of The Swim School, and hereby agrees to indemnify and hold harmless The Swim School and River Wilderness Golf & Country Club, its coaches, teachers, instructors, officers, directors, agents and employees against any liability resulting from any injury that may occur to the participant while participating in the Parrish Bull Sharks Swim Team. The participant also agrees to indemnify The Swim School and River Wilderness Golf & Country Club for any damages incurred arising from any claim, demand, action or cause of action by the participant. The participant and/or parent/guardian authorizes any representative, coaches, teachers, instructors, officers, directors, agents or employees of The Swim School to have the participant treated in any medical emergency during their participation in the swim program. Further, the participant and/or parent/guardian agree to pay all costs associated with medical care and transportation for the participant.</dd>


                <dt>Medical Acknowledgement:</dt>
                <dd>I certify that, to the best of my knowledge and belief, the participant is in good physical condition and has no condition that would impair participation in the Parrish Bull Sharks Swim Team program. Please notify Hilary Koppenhaver of any medical and/or health issues regarding your child that the swim team coaches should be aware of prior to the start of the swim team season. (i.e. allergies, epipen for allergic reaction, asthma, etc.)</dd>

                <dt>Photo and Video Policy:</dt>
                <dd>I am aware that individual and group publicity photos and videos are taken from time to time and in consideration for my child's participation, I hereby grant permission for my or my child's likeness to be used in company publicity and/or advertising.</dd>

                <dt>Facility and Pool Use:</dt>
                <dd>Fitness Center Facility use is for River Wilderness Country Club members only. Swim Team participants may use the locker rooms and pool during scheduled swim team practice times only and must be supervised by an adult when inside the facility. Use of the locker rooms and pool outside of swim team time is for River Wilderness Country Club members only.</dd>

                <dt>Swimmer Registration & Program Payment:</dt>
                <dd>All swimmers must register online following tryouts to reserve their spot on the swim team. Program fee must be paid online in full for the entire swim team season no later than Friday, May 12th. All payments are non refundable. No prorated discounts will be offered.</dd>

                <dt>Apparel/Equipment:</dt>
                <dd>We have a Parrish Bull Sharks online team apparel store linked through the swim team page of The Swim School website. It has team apparel items available for purchase for both swimmers and parents. For swim meets: All purchases must be made no later than May 12th, 2021 to ensure delivery by June 1st, 2021. Each child will receive one free team swim cap and one team t-shirt prior to the first swim meet of the season to use for the purpose of swim meet competitions, but the team swim suit must be purchased separately by each swimmer. For practices: Bathing suits and towels will not be supplied so please provide these items for your swimmer. We recommend a one piece bathing suit for female swimmers and a swim jammer or swim trunks for male swimmers. Goggles and a swim cap are highly recommended for improved vision, comfort and performance. Please supply your child with a pair of goggles and a swim cap for swim team practices. Equipment such as kick boards and pull buoys will be supplied by the Parrish Bull Sharks Swim Team but can also be purchased through the online team apparel store.</dd>

                <dt>Swim Team Group:</dt>
                <dd>The swim team coaches reserve the right to change a swimmer’s swim team group in accordance with their swimming abilities as necessary throughout the duration of the swim season.</dd>

                <dt>Safety:</dt>
                <dd>All children must be accompanied by an adult and directly supervised before and after their swim practices. There are no lifeguards at the facility.</dd>

                <dt>Practice Observation:</dt>
                <dd>In order to foster the best learning environment for each swimmer, the least amount of distraction is required. For swimmers to remain focused and fully attentive to their coaches during swim practices, parents and other family members are permitted on the pool deck but must view swimmers from the designated observation area. We ask that parents refrain from interrupting swimmers and coaches during practice times.</dd>

                <dt>Inclement Weather:</dt>
                <dd>In the event of inclement weather (i.e. lightning within 5.0 miles or less from pool location, heavy rain which limits visibility of the bottom of the pool, and/or air temperature of 65 degrees or below), swim practices will be cancelled. The coach will contact you via text when a practice needs to be cancelled due to inclement weather. It is best to assume swim practices are on as scheduled if you are not contacted by the coach. During practices, the coaches will remove all swimmers from the pool and relocate under the covered portion of the Fitness Center Facility immediately upon hearing loud approaching thunder and/or seeing lightning.</dd>

                <dt>No Makeup Practices/Observed Holidays:</dt>
                <dd>Swim practices will not be made up under any circumstances, including for cancelled practices due to inclement weather. The Parrish Bull Sharks Swim Team program will observe major nationally celebrated holidays (i.e. Memorial Day, Independence Day) and will not have practices on these days.</dd>

                <dt>Swim Meets/Championship Swim Meet:</dt>
                <dd>The Parrish Bull Sharks season swim meet schedule is available on the swim team page of The Swim School website. Swim meet participation is optional but highly encouraged. We participate in the Suncoast Summer Swim League. Swim meets take place on Saturday mornings. Travel includes the Bradenton area. A Championship meet is held at the end of the season (Sunday, August 1st 2021) and the cost is $20 per swimmer to participate. Each swimmer must participate in at least 4 swim meets throughout the season to be eligible to participate in the championship swim meet at the end of the season.</dd>

                <dt>Parent Volunteer Requirement:</dt>
                <dd>Swim meets only function with the help of parent volunteers. Parents of the Parrish Bull Sharks swim team are required to assist at swim meets in various roles throughout the season including swimmer lineup, timers, runners, etc. One parent per swimmer will be expected to either volunteer in at least 4 swim meets throughout the duration of the season or pay a $50 non-volunteer fee per swimmer.</dd>

                <dt>End Of Season Party/Awards:</dt>
                <dd>At the conclusion of the swim team season, we will have an awards party (late August) where each swimmer will be recognized with awards to honor their achievements.</dd>

                <dt>Parent Conduct:</dt>
                <dd>The goal of the Parrish Bull Sharks Swim Team is to foster a positive environment for all involved.  We will need the support and involvement of our parents to run an effective program. Just as we  will expect the swimmers to practice teamwork, good sportsmanship, and self-control, this will be  the same expected conduct for all parents as well. We encourage open communication but ask  that parents refrain from interrupting swimmers and coaches during practice times. Coaches will  make themselves available for pertinent discussion outside of practice times. As a parent, I  understand the Parrish Bull Sharks Swim Team maintains the right to dismiss anyone from  involvement with the team with or without cause if it brings discredit or discord to the program.</dd>

                <dt>Disciplinary Procedure:</dt>
                <dd>If a swimmer is disruptive (defined as any behavior which requires the full attention of a staff member,  thereby interfering with the functioning of the group) during swim practices or swim meets, the coaches  will use the following disciplinary procedure to handle situations:</dd>

                <h5>Level I – Minor Incidents</h5>

                <ul>
                    <li>
                        <p><b>First Action</b> - Swim coach will give two verbal warnings for swimmers to stop disruptive behavior.</p>
                    </li>
                    <li>
                        <p><b>Second Action</b> - Swimmer will be asked to sit out of practice time. The coach will decide if he/she is allowed back in the pool for the remainder of practice. Regardless of the decision, the swimmer will not be allowed to leave the pool deck unsupervised until the scheduled end of practice.</p>
                    </li>
                    <li>
                        <p><b>Third Action</b> - Discussion with parent(s) regarding disruptive behavior.</p>
                    </li>
                    <li>
                        <p><b>Fourth Action</b> - If the swimmer’s behavior continues to be disruptive beyond the first, second and third disciplinary actions taken, a meeting with the coaches, parent(s) and swimmer will be required for the swimmer to be able to return to the team.</p>
                    </li>
                </ul>

                <h5>Level II – Major Incidents</h5>

                <p>The following are prohibited:</p>

                <ol>
                    <li>
                        Possession or use of alcoholic beverages.
                    </li>
                    <li>
                        Possession or use of illegal drugs.
                    </li>
                    <li>
                        Inappropriate behavior and/or physical injury towards others.
                    </li>
                    <li>
                        Inappropriate behavior and/or physical injury towards coaching staff.
                    </li>
                    <li>
                        Destructive behavior of any kind.
                    </li>
                </ol>

                <ul>
                    <li>
                        <p><b>First Action</b> - The swimmer will be excused from practice and the parent will be informed. A meeting with the coaches, parent(s) and swimmer will be required for the swimmer to be able to return to the team.</p>
                    </li>
                    <li>
                        <p><b>Second Action</b> - The swimmer will be asked to leave the team. No refunds will be given.</p>
                    </li>
                </ul>

                <p>
                    **If an extreme incident occurs involving alcoholic beverages, illegal drugs and/or physical injury towards others, the swimmer(s) involved will be dismissed from the team immediately and no refunds will be given.**
                </p>

            </dl>

        </div>
    </div>
@endsection






