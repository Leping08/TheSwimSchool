import { createApp } from 'vue';

import SwimTeamRoster from './components/SwimTeamRoster.vue';
import PromoCode from './components/promoCode.vue';
import PrivateCalendar from './components/PrivateCalendar.vue';
import InstructorCalendar from './components/InstructorCalendar.vue';
import EmailEdit from './components/EmailEdit.vue';
import RealhabAttendance from './components/RealhabAttendance.vue';

const app = createApp({
    components: {
        SwimTeamRoster,
        PrivateCalendar,
        InstructorCalendar,
        promo_code: PromoCode,
        EmailEdit,
        RealhabAttendance,
    },
});

// The Blade page inside #app is compiled as the root template; keep Vue 2's whitespace handling so inline spacing doesn't change.
app.config.compilerOptions.whitespace = 'preserve';

app.mount('#app');
