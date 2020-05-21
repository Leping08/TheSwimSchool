@extends('layouts.app-uikit')

@section('seo')
    <title>Parrish Swim Lessons | Lakewood Ranch Swimming Classes | The Swim School</title>
    <meta name="description" content="The Swim School near Lakewood Ranch & Parrish is proud to offer private and semi-private swim lessons, as well as group swimming classes! Visit our website for more information."/>
@endsection

@section('heading')
About The Swim School
@endsection

@section('content')
<div class="uk-section-default uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="/img/lessons/kids-floating.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="Manatee County Children's swim lessons">
                </div>
            </div>
            <div class="uk-width-expand@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">History</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                <div class="uk-margin uk-dropcap">
                    <p>
                        In May 2015, The Swim School began offering <a href="{{ route('private_lesson.index') }}">private</a> and <a href="{{ route('groups.lessons.index') }}">group swim lessons</a> in Manatee County for adults and children 6 months of age and older. In addition to providing quality stroke instruction for all ability levels, The Swim School expanded their services and started the <a href="{{ route('swim-team.index') }}">{{ config('swim-team.full-name') }}</a> in May 2018, a seasonal program for youth ages 5-18.
                    </p>
                </div>
            </div>
        </div>


        <div id="Hilary" class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">Hilary Koppenhaver</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                <div class="uk-margin uk-dropcap">
                    <p>
                        Originally from Pennsylvania, Hilary started swimming at the age of five and continued competitively through college in Ohio where she earned a B.A. in Psychology. After receiving her degree in 2003, she returned to PA and worked part-time as a lifeguard, <a title="Bradenton Swim Instruction" href="{{ route('private_lesson.index') }}">swim lesson instructor</a>, and swim team coach in addition to having a full-time position in the human services field assisting children with special needs. With a love for the beach and a craving for a warmer climate, Hilary relocated to Florida in 2006 and worked as an Aquatics Director at a YMCA for over eight years where she developed a year round competitive swim team program, administered a progressive swim lesson program and conducted water fitness classes at two aquatics facilities. In May 2015, Hilary took her passion for teaching aquatics programs and established The Swim School. After seeing a great need in the community, she formed the Parrish Bull Sharks swim team in May 2018. Hilary strives to provide valuable, educational aquatics experiences for children of all ages and ability levels. She enjoys watching children progress and achieve new skills in the pool, and hopes to instill in her students a lifelong love for swimming. She is a certified Swim Lesson Instructor, Lifeguard, and CPR-PR/AED & First Aid Instructor.
                    </p>
                </div>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="/img/instructors/hilary.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="Lakewood Ranch Swim School">
                </div>
            </div>
        </div>

        <div id="Michelle" class="uk-flex-middle uk-grid-margin uk-grid" uk-grid="">
            <div class="uk-width-expand@m">
                <div class="uk-margin">
                    <img src="/img/instructors/michelle.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="Manatee County Children's swim lessons">
                </div>
            </div>
            <div class="uk-width-expand@m uk-first-column">
                <h2 class="uk-text-center uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">Michelle Meerman</h2>
                <hr class="uk-divider-icon uk-scrollspy-inview uk-animation-slide-top-medium" uk-scrollspy-class="">
                <div class="uk-margin uk-dropcap">
                    <p>
                        Michelle grew up in Sarasota, Florida, where her love for the water began at a young age and she was swimming on her own by the time she was three years old. Michelle swam competitively with the Sarasota YMCA Sharks Swim Team for many years and became a certified lifeguard and swim instructor as soon as she was old enough to be hired for employment. While she loved her time in the sun and sand, Michelle embarked on a new adventure after graduating high school that led her to Warsaw, Poland, in pursuit of her B.A. degree in International Relations which she obtained in 2019. Michelle was recruited as a Swim Lesson Instructor in 2016 and has been an amazing asset to The Swim School ever since. She is a certified Swim Lesson Instructor.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

