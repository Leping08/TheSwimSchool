@extends('layouts.app-uikit')

@section('seo')
    <title>Bradenton Private Swim Lessons | Parrish Swim Instructors | Ellenton</title>
    <meta name="description" content="Our Ellenton and Parrish swim instructors at The Swim School are available to help you achieve your swimming goals! Request your Bradenton private swim lessons here."/>
@endsection

@section('heading')
    Private Lessons
@endsection

@section('content')
    <div class="uk-section-default uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-3-4@m uk-first-column">
                    <div class="uk-margin uk-dropcap">
                        Whether you are a beginner swimmer, a child preparing to join a <a title="Parrish Swim Team" href="/swim-team">swim team</a>, or a triathlete
                        looking to improve your technique, private and semi-private swim lessons can be customized to your specific needs to help you achieve your goals quickly.
                        These lessons can be purchased monthly in packages of four (4) or eight (8) lessons at your pool or our Harrison Ranch location.
                    </div>
                </div>
                <div class="uk-width-expand@m">
                    <div class="uk-margin">
                        <img src="/img/swim-lessons.jpg" class="el-image uk-border-rounded uk-box-shadow-large" alt="Palmetto Swim Instruction">
                    </div>
                </div>
            </div>



            <div class="uk-grid-margin uk-grid" uk-grid="">
                <div class="uk-width-4-4@m uk-first-column">
                    <h2 class="uk-heading-bullet">Private Lesson Package Options</h2>
                    <p class="uk-text-meta">Private lessons are conducted one-on-one with an instructor.</p>
                    <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <ul class="uk-list uk-list-bullet">
                                    <li>Four 30 Minute Lessons (1x/week)</li>
                                    <li>Our Pool = $140/Month</li>
                                    <li>Your Pool = $180/Month</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <ul class="uk-list uk-list-bullet">
                                    <li>Eight 30 Minute Lessons (2x/week)</li>
                                    <li>Our Pool = $280/Month</li>
                                    <li>Your Pool = $360/Month</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="uk-width-4-4@m uk-first-column">
                    <h2 class="uk-heading-bullet">Semi-Private Lesson Package Options</h2>
                    <p class="uk-text-meta">Semi-Private lessons can be requested if you have siblings or friends close in age and ability level who would like to receive swim instruction together</p>
                    <div class="uk-child-width-1-2@m uk-grid-small uk-grid-match" uk-grid>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <ul class="uk-list uk-list-bullet">
                                    <li>Four 30 Minute Lessons (1x/week)</li>
                                    <li>Our Pool = $80/Month per child</li>
                                    <li>Your Pool = $100/Month per child</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body">
                                <ul class="uk-list uk-list-bullet">
                                    <li>Eight 30 Minute Lessons (2x/week)</li>
                                    <li>Our Pool = $160/Month per child</li>
                                    <li>Your Pool = $200/Month per child</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid="">
                <div class="uk-width-1-1@m uk-first-column">
                    <div class="uk-margin uk-scrollspy-inview uk-animation-slide-bottom-medium" uk-scrollspy-class="">
                        <div class="uk-card uk-card-default uk-card-body">
                            <div class="uk-h2">Request Private Lessons</div>
                            <form action="" method="post">
                                {{ csrf_field() }}
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Name</label>
                                    <div class="uk-form-controls">
                                        <input type="text" name="name" value="{{ old('name') }}" class="uk-input" placeholder="Full Name" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Email</label>
                                    <div class="uk-form-controls">
                                        <input type="email" name="email" value="{{ old('email') }}" class="uk-input" placeholder="Email@email.com" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Phone</label>
                                    <div class="uk-form-controls">
                                        <input type="tel" name="phone" value="{{ old('phone') }}" class="uk-input" placeholder="999 999-9999" required>
                                    </div>
                                </div>
                                <div class="uk-margin">
                                    <label class="uk-form-label uk-heading-bullet" for="">Message</label>
                                    <div class="uk-form-controls">
                                        <textarea name="message" rows="5" class="uk-textarea" placeholder="I would like to schedule private and/or semi-private lessons." required>{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div uk-grid="" class="uk-grid">
                                    <div class="uk-width-1-2@s uk-margin">
                                        <input type="submit" value="Send" class="uk-button-primary uk-button uk-button-large">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection