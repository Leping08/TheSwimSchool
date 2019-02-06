<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80">{{ label }}</h4>
            </slot>
        </div>
        <div class="w-3/4 py-4">
            <slot name="value">
                <p v-if="link" class="text-90"><a class="no-underline font-bold dim text-primary" target="_blank" :href="link">{{ linkText }}</a></p>
                <p v-else>&mdash;</p>
            </slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],

    data () {
        return {
            label: 'Link',
            linkText: 'Sign Up Link',
            link: ''
        }
    },

    created() {
        console.log(this.resourceId);
        this.getLessonLink()
    },

    methods: {
        getLessonLink: function () {
            axios.get('/api/lesson-link/' + this.resourceId)
            .then((response) => {
                console.log(response.data);
                this.link = response.data + '/' + this.resourceId;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
}
</script>
