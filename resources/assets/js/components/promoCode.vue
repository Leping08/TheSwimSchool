<template>
    <div class="uk-margin uk-width-1-1@s">
        <div class="uk-margin uk-width-1-1@s">
            <label class="uk-form-label uk-heading-bullet" for="promoCode">Promo Code</label>
            <div class="uk-form-controls">
                <input type="text" class="uk-input" id="promoCode" name="promoCode" placeholder="" v-model="code" required>
            </div>
        </div>
        Price is: {{price}} - {{code}}
    </div>
</template>

<script>
    export default {
        props: ['price'],
        data() {
            return {
                code: ''
            }
        },
        mounted() {

        }
    }
</script>