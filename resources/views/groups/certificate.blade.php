<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <style>
        /*
! tailwindcss v3.4.3 | MIT License | https://tailwindcss.com
*/
        /*
1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
*/
        *,
        ::before,
        ::after {
            box-sizing: border-box;
            /* 1 */
            border-width: 0;
            /* 2 */
            border-style: solid;
            /* 2 */
            border-color: #e5e7eb;
            /* 2 */
        }

        ::before,
        ::after {
            --tw-content: '';
        }

        /*
1. Use a consistent sensible line-height in all browsers.
2. Prevent adjustments of font size after orientation changes in iOS.
3. Use a more readable tab size.
4. Use the user's configured `sans` font-family by default.
5. Use the user's configured `sans` font-feature-settings by default.
6. Use the user's configured `sans` font-variation-settings by default.
7. Disable tap highlights on iOS
*/
        html,
        :host {
            line-height: 1.5;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
            -moz-tab-size: 4;
            /* 3 */
            tab-size: 4;
            /* 3 */
            font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            /* 4 */
            font-feature-settings: normal;
            /* 5 */
            font-variation-settings: normal;
            /* 6 */
            -webkit-tap-highlight-color: transparent;
            /* 7 */
        }

        /*
1. Remove the margin in all browsers.
2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
*/
        body {
            margin: 0;
            /* 1 */
            line-height: inherit;
            /* 2 */
        }

        /*
1. Add the correct height in Firefox.
2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
3. Ensure horizontal rules are visible by default.
*/
        hr {
            height: 0;
            /* 1 */
            color: inherit;
            /* 2 */
            border-top-width: 1px;
            /* 3 */
        }

        /*
Add the correct text decoration in Chrome, Edge, and Safari.
*/
        abbr:where([title]) {
            text-decoration: underline dotted;
        }

        /*
Remove the default font size and weight for headings.
*/
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: inherit;
            font-weight: inherit;
        }

        /*
Reset links to optimize for opt-in styling instead of opt-out.
*/
        a {
            color: inherit;
            text-decoration: inherit;
        }

        /*
Add the correct font weight in Edge and Safari.
*/
        b,
        strong {
            font-weight: bolder;
        }

        /*
1. Use the user's configured `mono` font-family by default.
2. Use the user's configured `mono` font-feature-settings by default.
3. Use the user's configured `mono` font-variation-settings by default.
4. Correct the odd `em` font sizing in all browsers.
*/
        code,
        kbd,
        samp,
        pre {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            /* 1 */
            font-feature-settings: normal;
            /* 2 */
            font-variation-settings: normal;
            /* 3 */
            font-size: 1em;
            /* 4 */
        }

        /*
Add the correct font size in all browsers.
*/
        small {
            font-size: 80%;
        }

        /*
Prevent `sub` and `sup` elements from affecting the line height in all browsers.
*/
        sub,
        sup {
            font-size: 75%;
            line-height: 0;
            position: relative;
            vertical-align: baseline;
        }

        sub {
            bottom: -0.25em;
        }

        sup {
            top: -0.5em;
        }

        /*
1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
3. Remove gaps between table borders by default.
*/
        table {
            text-indent: 0;
            /* 1 */
            border-color: inherit;
            /* 2 */
            border-collapse: collapse;
            /* 3 */
        }

        /*
1. Change the font styles in all browsers.
2. Remove the margin in Firefox and Safari.
3. Remove default padding in all browsers.
*/
        button,
        input,
        optgroup,
        select,
        textarea {
            font-family: inherit;
            /* 1 */
            font-feature-settings: inherit;
            /* 1 */
            font-variation-settings: inherit;
            /* 1 */
            font-size: 100%;
            /* 1 */
            font-weight: inherit;
            /* 1 */
            line-height: inherit;
            /* 1 */
            letter-spacing: inherit;
            /* 1 */
            color: inherit;
            /* 1 */
            margin: 0;
            /* 2 */
            padding: 0;
            /* 3 */
        }

        /*
Remove the inheritance of text transform in Edge and Firefox.
*/
        button,
        select {
            text-transform: none;
        }

        /*
1. Correct the inability to style clickable types in iOS and Safari.
2. Remove default button styles.
*/
        button,
        input:where([type='button']),
        input:where([type='reset']),
        input:where([type='submit']) {
            -webkit-appearance: button;
            /* 1 */
            background-color: transparent;
            /* 2 */
            background-image: none;
            /* 2 */
        }

        /*
Use the modern Firefox focus style for all focusable elements.
*/
        :-moz-focusring {
            outline: auto;
        }

        /*
Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
*/
        :-moz-ui-invalid {
            box-shadow: none;
        }

        /*
Add the correct vertical alignment in Chrome and Firefox.
*/
        progress {
            vertical-align: baseline;
        }

        /*
Correct the cursor style of increment and decrement buttons in Safari.
*/
        ::-webkit-inner-spin-button,
        ::-webkit-outer-spin-button {
            height: auto;
        }

        /*
1. Correct the odd appearance in Chrome and Safari.
2. Correct the outline style in Safari.
*/
        [type='search'] {
            -webkit-appearance: textfield;
            /* 1 */
            outline-offset: -2px;
            /* 2 */
        }

        /*
Remove the inner padding in Chrome and Safari on macOS.
*/
        ::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        /*
1. Correct the inability to style clickable types in iOS and Safari.
2. Change font properties to `inherit` in Safari.
*/
        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            /* 1 */
            font: inherit;
            /* 2 */
        }

        /*
Add the correct display in Chrome and Safari.
*/
        summary {
            display: list-item;
        }

        /*
Removes the default spacing and border for appropriate elements.
*/
        blockquote,
        dl,
        dd,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        hr,
        figure,
        p,
        pre {
            margin: 0;
        }

        fieldset {
            margin: 0;
            padding: 0;
        }

        legend {
            padding: 0;
        }

        ol,
        ul,
        menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        /*
Reset default styling for dialogs.
*/
        dialog {
            padding: 0;
        }

        /*
Prevent resizing textareas horizontally by default.
*/
        textarea {
            resize: vertical;
        }

        /*
1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
2. Set the default placeholder color to the user's configured gray 400 color.
*/
        input::placeholder,
        textarea::placeholder {
            opacity: 1;
            /* 1 */
            color: #9ca3af;
            /* 2 */
        }

        /*
Set the default cursor for buttons.
*/
        button,
        [role="button"] {
            cursor: pointer;
        }

        /*
Make sure disabled buttons don't get the pointer cursor.
*/
        :disabled {
            cursor: default;
        }

        /*
1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
   This can trigger a poorly considered lint error in some tools but is included by design.
*/
        img,
        svg,
        video,
        canvas,
        audio,
        iframe,
        embed,
        object {
            display: block;
            /* 1 */
            vertical-align: middle;
            /* 2 */
        }

        /*
Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
*/
        img,
        video {
            max-width: 100%;
            height: auto;
        }

        /* Make elements with the HTML hidden attribute stay hidden by default */
        [hidden] {
            display: none;
        }

        *,
        ::before,
        ::after {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style: ;
        }

        ::backdrop {
            --tw-border-spacing-x: 0;
            --tw-border-spacing-y: 0;
            --tw-translate-x: 0;
            --tw-translate-y: 0;
            --tw-rotate: 0;
            --tw-skew-x: 0;
            --tw-skew-y: 0;
            --tw-scale-x: 1;
            --tw-scale-y: 1;
            --tw-pan-x: ;
            --tw-pan-y: ;
            --tw-pinch-zoom: ;
            --tw-scroll-snap-strictness: proximity;
            --tw-gradient-from-position: ;
            --tw-gradient-via-position: ;
            --tw-gradient-to-position: ;
            --tw-ordinal: ;
            --tw-slashed-zero: ;
            --tw-numeric-figure: ;
            --tw-numeric-spacing: ;
            --tw-numeric-fraction: ;
            --tw-ring-inset: ;
            --tw-ring-offset-width: 0px;
            --tw-ring-offset-color: #fff;
            --tw-ring-color: rgb(59 130 246 / 0.5);
            --tw-ring-offset-shadow: 0 0 #0000;
            --tw-ring-shadow: 0 0 #0000;
            --tw-shadow: 0 0 #0000;
            --tw-shadow-colored: 0 0 #0000;
            --tw-blur: ;
            --tw-brightness: ;
            --tw-contrast: ;
            --tw-grayscale: ;
            --tw-hue-rotate: ;
            --tw-invert: ;
            --tw-saturate: ;
            --tw-sepia: ;
            --tw-drop-shadow: ;
            --tw-backdrop-blur: ;
            --tw-backdrop-brightness: ;
            --tw-backdrop-contrast: ;
            --tw-backdrop-grayscale: ;
            --tw-backdrop-hue-rotate: ;
            --tw-backdrop-invert: ;
            --tw-backdrop-opacity: ;
            --tw-backdrop-saturate: ;
            --tw-backdrop-sepia: ;
            --tw-contain-size: ;
            --tw-contain-layout: ;
            --tw-contain-paint: ;
            --tw-contain-style: ;
        }

        .absolute {
            position: absolute;
        }

        .relative {
            position: relative;
        }

        .-bottom-10 {
            bottom: -2.5rem;
        }

        .-left-5 {
            left: -1.25rem;
        }

        .-left-60 {
            left: -15rem;
        }

        .left-0 {
            left: 0px;
        }

        .left-10 {
            left: 2.5rem;
        }

        .left-16 {
            left: 4rem;
        }

        .left-20 {
            left: 5rem;
        }

        .right-0 {
            right: 0px;
        }

        .right-20 {
            right: 5rem;
        }

        .top-0 {
            top: 0px;
        }

        .top-16 {
            top: 4rem;
        }

        .top-80 {
            top: 20rem;
        }

        .z-10 {
            z-index: 10;
        }

        .z-20 {
            z-index: 20;
        }

        .z-30 {
            z-index: 30;
        }

        .m-20 {
            margin: 5rem;
        }

        .-my-2 {
            margin-top: -0.5rem;
            margin-bottom: -0.5rem;
        }

        .mx-24 {
            margin-left: 6rem;
            margin-right: 6rem;
        }

        .my-4 {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .mr-8 {
            margin-right: 2rem;
        }

        .mt-10 {
            margin-top: 2.5rem;
        }

        .mt-14 {
            margin-top: 3.5rem;
        }

        .flex {
            display: flex;
        }

        .h-0 {
            height: 0px;
        }

        .h-0\.5 {
            height: 0.125rem;
        }

        .h-1 {
            height: 0.25rem;
        }

        .h-20 {
            height: 5rem;
        }

        .h-36 {
            height: 9rem;
        }

        .h-64 {
            height: 16rem;
        }

        .h-72 {
            height: 18rem;
        }

        .h-96 {
            height: 24rem;
        }

        .h-screen {
            height: 100vh;
        }

        .w-20 {
            width: 5rem;
        }

        .w-24 {
            width: 6rem;
        }

        .w-28 {
            width: 7rem;
        }

        .w-36 {
            width: 9rem;
        }

        .w-60 {
            width: 15rem;
        }

        .w-64 {
            width: 16rem;
        }

        .w-96 {
            width: 24rem;
        }

        .w-full {
            width: 100%;
        }

        .w-screen {
            width: 100vw;
        }

        .-translate-x-6 {
            --tw-translate-x: -1.5rem;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .-translate-y-4 {
            --tw-translate-y: -1rem;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .-rotate-12 {
            --tw-rotate: -12deg;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .-rotate-45 {
            --tw-rotate: -45deg;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .rotate-12 {
            --tw-rotate: 12deg;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .rotate-19 {
            --tw-rotate: 19deg;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .rotate-45 {
            --tw-rotate: 45deg;
            transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
        }

        .items-center {
            align-items: center;
        }

        .justify-end {
            justify-content: flex-end;
        }

        .justify-center {
            justify-content: center;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .bg-black {
            --tw-bg-opacity: 1;
            background-color: rgb(0 0 0 / var(--tw-bg-opacity));
        }

        .bg-blue-800 {
            --tw-bg-opacity: 1;
            background-color: rgb(30 64 175 / var(--tw-bg-opacity));
        }

        .bg-sky-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(14 165 233 / var(--tw-bg-opacity));
        }

        .bg-white {
            --tw-bg-opacity: 1;
            background-color: rgb(255 255 255 / var(--tw-bg-opacity));
        }

        .p-10 {
            padding: 2.5rem;
        }

        .pr-6 {
            padding-right: 1.5rem;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-mr-dafoe {
            font-family: Mr Dafoe, sans-serif;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-4xl {
            font-size: 2.25rem;
            line-height: 2.5rem;
        }

        .text-8xl {
            font-size: 6rem;
            line-height: 1;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-xl {
            font-size: 1.25rem;
            line-height: 1.75rem;
        }

        .font-bold {
            font-weight: 700;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .italic {
            font-style: italic;
        }

        .tracking-widest {
            letter-spacing: 0.1em;
        }

        .text-black {
            --tw-text-opacity: 1;
            color: rgb(0 0 0 / var(--tw-text-opacity));
        }

        .text-blue-800 {
            --tw-text-opacity: 1;
            color: rgb(30 64 175 / var(--tw-text-opacity));
        }

        .text-gray-800 {
            --tw-text-opacity: 1;
            color: rgb(31 41 55 / var(--tw-text-opacity));
        }

        .text-sky-500 {
            --tw-text-opacity: 1;
            color: rgb(14 165 233 / var(--tw-text-opacity));
        }

        .ring-6 {
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(6px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
        }

        .ring-white {
            --tw-ring-opacity: 1;
            --tw-ring-color: rgb(255 255 255 / var(--tw-ring-opacity));
        }

        .clip-edge {
            background: linear-gradient(-135deg, transparent 4%, white 0%) top right, linear-gradient(135deg, transparent 4%, white 0%) top left, linear-gradient(-45deg, transparent 4%, white 0%) bottom right, linear-gradient(45deg, transparent 4%, white 0%) bottom left;
            background-repeat: no-repeat;
            background-size: 75% 75%;
        }
    </style>
</head>



<body>
    <!--
        Welcome to Tailwind Play, the official Tailwind CSS playground!

        Everything here works just like it does when you're running Tailwind locally
        with a real build pipeline. You can customize your config file, use features
        like `@apply`, or even add third-party plugins.

        Feel free to play with this example if you're just learning, or trash it and
        start from scratch if you know enough to be dangerous. Have fun!

        Edit code here: https://play.tailwindcss.com/m9xD8NBJRV?size=1400x900
    -->

    <link href="https://fonts.googleapis.com/css2?family=Mr+Dafoe&display=swap" rel="stylesheet" />

    <div class="relative flex h-screen w-full justify-center overflow-hidden bg-white">
        <img class="absolute h-screen w-screen" src="{{ asset('/img/certificate/background.jpg') }}" />
        <div class="absolute -left-60 top-0 z-10 mt-14 h-36 w-full -translate-x-6 -rotate-45 bg-blue-800"></div>
        <div class="clip-edge relative m-20 w-full bg-white">
            <div class="absolute left-0 top-0 z-20 h-96 w-96 text-sky-500">
                <div class="relative">
                    <svg class="absolute right-0 top-0 rotate-19" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <title>decagram</title>
                        <path
                            d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12Z"
                            fill="currentColor" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="">
                        <title>decagram</title>
                        <path
                            d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12Z"
                            fill="currentColor" />
                        <div>
                            <img src="{{ asset('img/logos/the-swim-school-light-new.png') }}"
                                class="absolute left-16 top-16 z-30 w-64" />
                        </div>
                        <div class="absolute left-20 top-80 -translate-y-4">
                            <div class="relative">
                                <div class="h-72 w-24 rotate-12 bg-sky-500"></div>
                                <div class="absolute -bottom-10 -left-5 rotate-12">
                                    <div class="h-20 w-20 rotate-45 bg-white"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute right-20 top-80 -translate-y-4">
                            <div class="relative">
                                <div class="h-72 w-24 -rotate-12 bg-sky-500"></div>
                                <div class="absolute -bottom-10 left-10 -rotate-12">
                                    <div class="h-20 w-20 rotate-45 bg-white"></div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute left-16 top-16">
                            <div class="h-64 w-64 rounded-full ring-6 ring-white"></div>
                        </div>
                    </svg>
                </div>
            </div>

            <div class="p-10 text-right">
                <div class="mb-8 mt-10 text-8xl font-bold uppercase tracking-widest text-blue-800">Graduation</div>
                <div class="mb-6 flex items-center justify-end">
                    <div class="text-4xl font-bold uppercase tracking-widest text-sky-500">Dipolima</div>
                    <div class="h-1 w-36 bg-blue-800"></div>
                </div>
                <div class="mb-6 text-2xl font-bold uppercase text-black">Proudly Awarded To</div>
                <div class="mb-6 mr-8 font-mr-dafoe text-8xl text-blue-800">{{ $swimmer_name }}</div>
                <div class="text-2xl uppercase text-gray-800">In recognition of mastering skills and</div>
                <div class="text-2xl uppercase text-gray-800">Achieving level progression</div>
                <div class="flex items-center justify-end my-4">
                    <img src="{{ $level_icon }}" class="-my-2 mr-8 w-28" />
                    <div class="text-4xl font-bold italic text-blue-800">{{ $level_name }}</div>
                </div>
                <div class="mb-6 flex items-center justify-end">
                    <div class="mx-24 text-center">
                        <div class="mb-2 text-xl font-bold uppercase text-sky-500">{{ $instructor_name }}</div>
                        <div class="mb-2 h-0.5 w-60 bg-black"></div>
                        <div class="text-lg uppercase">Instructor</div>
                    </div>
                    <div class="pr-6 text-center">
                        <div class="mb-2 text-xl font-bold uppercase text-sky-500">{{ $lesson_completed_date }}</div>
                        <div class="mb-2 h-0.5 w-60 bg-black"></div>
                        <div class="text-lg uppercase">Date</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
