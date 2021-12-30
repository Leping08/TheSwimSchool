@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Swim Lessons | Ellenton Swimming Classes | The Swim School</title>
    <meta name="description" content="The Swim School near Parrish & Ellenton is proud to offer private and semi-private swim lessons, as well as group swimming classes! Visit our website for more information."/>
@endsection

@section('heading')
About The Swim School
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-flex-middle uk-grid-margin uk-grid">
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="{{ asset('/img/lessons/kids-floating.jpg') }}" class="el-image uk-border-rounded uk-box-shadow-large" alt="Parrish Children's swim lessons">
                </div>
            </div>
            <div class="uk-width-expand@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium uk-margin-top">History</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium">
                <div class="uk-margin uk-dropcap">
                    <p>
                        In May 2015, The Swim School began offering <a title="Private Swim Lessons Parrish" href="{{ route('private_lesson.index') }}">private</a> and <a title="Group Swimming Parrish" href="{{ route('groups.lessons.index') }}">group swim lessons</a> in Manatee County for adults and children 6 months of age and older. In addition to providing quality stroke instruction for all ability levels, The Swim School expanded their services and started the <a title="Youth Swim Team near Ellenton" href="{{ route('swim-team.index') }}">{{ config('swim-team.full-name') }}</a> in May 2018, a seasonal program for youth ages 5-18.
                    </p>
                </div>
            </div>
        </div>


        <div id="Hilary Koppenhaver" class="uk-grid-margin uk-grid">
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="{{ asset('/img/instructors/hilary.jpg') }}" class="el-image uk-border-rounded uk-box-shadow-large" alt="Ellenton Swim School">
                </div>
            </div>
            <div class="uk-width-expand@m uk-flex-first@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium uk-margin-top">Hilary Koppenhaver</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium">
                <div class="uk-margin uk-dropcap">
                    <p>
                        Originally from Pennsylvania, Hilary started swimming at the age of five and continued competitively through college in Ohio where she earned a B.A. in Psychology. After receiving her degree in 2003, she returned to PA and worked part-time as a lifeguard, <a title="Bradenton Swim Instruction" href="{{ route('private_lesson.index') }}">swim lesson instructor</a>, and swim team coach in addition to having a full-time position in the human services field assisting children with special needs. With a love for the beach and a craving for a warmer climate, Hilary relocated to Florida in 2006 and worked as an Aquatics Director at a YMCA for over eight years where she developed a year round competitive swim team program, administered a progressive swim lesson program and conducted water fitness classes at two aquatics facilities. In May 2015, Hilary took her passion for teaching aquatics programs and established The Swim School. After seeing a great need in the community, she formed the Parrish Bull Sharks swim team in May 2018. Hilary strives to provide valuable, educational aquatics experiences for children of all ages and ability levels. She enjoys watching children progress and achieve new skills in the pool, and hopes to instill in her students a lifelong love for swimming. She is a certified Swim Lesson Instructor, Lifeguard, and CPR-PR/AED & First Aid Instructor.
                    </p>
                    <div class="uk-margin-bottom">
                        <a title="Parrish Swim School" class="uk-button uk-button-secondary" href="tel:+19417731424"><span uk-icon="icon: receiver" class=""></span> (941) 773-1424</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="Jacie" class="uk-flex-middle uk-grid-margin uk-grid">
{{--            <div class="uk-width-expand@m">--}}
{{--                <div class="uk-margin">--}}
{{--                    <img src="{{ asset('/img/instructors/michelle.jpg') }}" class="el-image uk-border-rounded uk-box-shadow-large" alt="Manatee County Children's swim lessons">--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="uk-width-expand@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium uk-margin-top">Jacie Dyer</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium">
                <div class="uk-margin uk-dropcap">
                    <p>
                        Jacie is a senior at Manatee School for the Arts. Originally from Maine, she learned how to swim at a very young age. Jacie moved to Florida when she was seven years old and by the summer before entering middle school, she joined her first swim team with the Bradenton YMCA. After competing for two summer seasons, she fell in love with the sport of swimming and joined a year-round team at the Lakewood Ranch YMCA. She swam there until moving to the North River Rapids (now Parrish Bull Sharks) summer swim team in Parrish.

                    </p>
                    <p>
                        In 2020, Jacie was hired as a summer camp counselor and lifeguard for the River Wilderness Golf & Country Club Sports Camp. She developed a swim program specifically for the camp participants based on their ages and abilities, and has served as the lead swim instructor/coach for the camp for the past two summers. Jacie has a passion for teaching swimming and is excited for the opportunity to work as a swim instructor for The Swim School and swim coach for the Parrish Bull Sharks swim team.
                    </p>
                    {{-- <div class="uk-margin-bottom">
                        <a title="Parrish Swim School" class="uk-button uk-button-secondary" href="tel:+12078314179"><span uk-icon="icon: receiver" class=""></span> (207) 831-4179</a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

