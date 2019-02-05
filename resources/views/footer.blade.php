<div class="tm-footer uk-section-muted uk-section-overlap uk-section">
    <div class="uk-container">
        <div class="uk-child-width-expand uk-text-center" uk-grid>
            <div></div>
            <div class="uk-visible@s"></div>
            <div>
                <div class="uk-margin uk-text-center@m uk-text-center">
                    <a title="Parrish swimming lessons" href="/" class="el-link"><img src="/img/logos/the-swim-school.png" class="uk-responsive-width" alt="Bradenton Swim School"></a>
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
                                    <a title="The Swim School" href="tel:+19417731424">(941) 773-1424</a>
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
                                    <a title="Manatee County Swimming Lessons" href="mailto:info@theswimschoolfl.com">info@theswimschoolfl.com</a>
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
                            <a title="The Swim School Facebook" uk-icon="icon: facebook" href="https://www.facebook.com/theswimschoolfl/" class="el-link uk-icon-button"></a>
                        </div>
                        <div>
                            <a title="The Swim School Instagram" uk-icon="icon: instagram" href="https://www.instagram.com/theswimschoolfl/" class="el-link uk-icon-button"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-expand@m">
                <div class="uk-margin-small-bottom">Sign up for our newsletter</div>
                <div class="uk-width-large uk-text-left@s uk-text-center">
                    <form class="uk-form uk-panel" method="post" action="/newsletter">
                        @csrf
                        <div class="uk-child-width-expand@s uk-grid uk-grid-stack" uk-grid="">
                            <div class="uk-position-relative uk-first-column">
                                <button class="el-button uk-form-icon uk-form-icon-flip uk-icon" uk-icon="icon: mail;" title="Subscribe"><svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="mail"><polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5"></polyline><path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z"></path></svg></button>
                                <input class="el-input uk-input uk-form-large" type="email" name="email" placeholder="Your E-Mail Address" required>
                            </div>
                        </div>
                        <div class="message uk-margin uk-hidden"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="uk-grid-margin" uk-grid>
            <div class="uk-width-1-1@m">
                <hr>
                <div class="uk-margin uk-text-center uk-text-meta">
                    Copyright &copy; {{date("Y")}}</br>
                    <a href="http://www.deltavcreative.com/" target="_blank">DeltaV Creative</a><br>
                    <a href="#" uk-totop uk-scroll></a>
                </div>
            </div>
        </div>
    </div>
</div>
