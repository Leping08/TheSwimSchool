<div class="tm-footer uk-section-muted uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-child-width-expand uk-text-center" uk-grid>
            <div></div>
            <div class="uk-visible@s"></div>
            <div>
                <div class="uk-margin uk-text-center@m uk-text-center">
                    <a title="Parrish swimming lessons" href="{{route('home.index')}}" class="el-link"><img src="{{ asset('/img/logos/the-swim-school.png') }}" class="uk-responsive-width" alt="Bradenton Swim School"></a>
                </div>
            </div>
            <div class="uk-visible@s"></div>
            <div></div>
        </div>
    </div>
</div>

<div class="uk-section-secondary uk-section-overlap uk-section uk-section-small">
    <div class="uk-container">
        <div class="uk-grid-margin" uk-grid>
            <div class="uk-width-expand@m">
                <ul class="uk-list">
                    <li class="">
                        <div class="uk-grid-small uk-child-width-expand uk-flex-nowrap uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <span  uk-icon="icon: star" class=""></span>
                            </div>
                            <div>
                                <div class="">
                                    Certified Aquatics Instructors
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="">
                        <div class="uk-grid-small uk-child-width-expand uk-flex-nowrap uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <span  uk-icon="icon: receiver" class=""></span>
                            </div>
                            <div>
                                <div class="">
                                    <a title="Swim Lessons Parrish" href="{{ config('contact.phone.link') }}">{{ config('contact.phone.number') }}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="">
                        <div class="uk-grid-small uk-child-width-expand uk-flex-nowrap uk-flex-middle" uk-grid>
                            <div class="uk-width-auto">
                                <span  uk-icon="icon: mail" class=""></span>
                            </div>
                            <div>
                                <div class="">
                                    <a title="Manatee County Swimming Lessons" href="{{ config('contact.email.link') }}">{{ config('contact.email.address') }}</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-margin uk-text-center">
                    <div class="uk-child-width-auto uk-grid-small uk-flex-center" uk-grid>
                        <div>
                            <a title="The Swim School Facebook" target="_blank" uk-icon="icon: facebook" href="{{ config('social.the_swim_school.facebook') }}" class="el-link uk-icon-button"></a>
                        </div>
                        <div>
                            <a title="The Swim School Instagram" target="_blank" uk-icon="icon: instagram" href="{{ config('social.the_swim_school.instagram') }}" class="el-link uk-icon-button"></a>
                        </div>
                        <div>
                            <a title="The Swim School TikTok" target="_blank" uk-icon="icon: tiktok" href="{{ config('social.the_swim_school.tiktok') }}" class="el-link uk-icon-button"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-margin-small-bottom">Sign up for our newsletter</div>
                <div class="uk-width-large uk-text-left@s uk-text-center">
                    <form class="uk-form uk-panel" method="post" action="{{ route('newsletter.subscribe') }}">
                        @csrf
                        <div class="uk-child-width-expand@s uk-grid uk-grid-stack" uk-grid="">
                            <div class="uk-position-relative uk-first-column">
                                <button class="el-button uk-form-icon uk-form-icon-flip uk-icon" uk-icon="icon: mail;" title="Subscribe"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="mail"><polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5"></polyline><path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z"></path></svg></button>
                                <input class="el-input uk-input uk-form-large" type="email" name="email" placeholder="Your E-Mail Address" required>
                            </div>
                        </div>

                        <input type="text" autocomplete="off" name="emailaddress" id="emailaddress" placeholder="" value="" class="uk-hidden" tabindex="-1">
                        <input type="text" autocomplete="off" name="email_address" id="email_address" placeholder="" value="" class="uk-hidden" tabindex="-1">
                        <input type="text" autocomplete="off" name="time" id="time" value="{{ Carbon\Carbon::now()->timestamp }}" class="uk-hidden" tabindex="-1">

                        <div class="message uk-margin uk-hidden"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="uk-grid-margin" uk-grid>
            <div class="uk-width-1-1@m">
                <hr>
                <div class="uk-margin uk-text-center uk-text-meta">
                    <div>
                        Copyright &copy; {{date("Y")}} <br/> <a href="{{ route('home.index') }}" target="_blank">The Swim School</a>
                    </div>
                    <div class="uk-margin-top">
                        Powered By <a href="https://deltavcreative.com/" target="_blank">DeltaV Creative</a><br>
                    </div>
                    <a href="#" uk-totop uk-scroll></a>
                </div>
            </div>
        </div>
    </div>
</div>
