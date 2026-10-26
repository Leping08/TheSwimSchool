<template>
    <div class="uk-width-1-1">
        <hr class="uk-width-1-1">
        <div class="uk-h2 uk-margin uk-width-1-1">
            Promo Code
        </div>
        <div class="uk-margin uk-width-1-1@s">
            <label class="uk-form-label uk-heading-bullet" for="promo_code">Code</label>
            <div class="uk-flex uk-flex-wrap uk-flex-wrap-around">
                <div class="uk-width-1-2">
                    <div class="uk-form-controls">
                        <input type="text" class="uk-input" id="promo_code" name="promo_code" placeholder="" v-model="code">
                    </div>
                </div>
                <div class="uk-width-1-2">
                    <div class="uk-margin-left">
                        <a @click="checkPromoCode()" class="uk-button uk-button-secondary">Apply</a>
                    </div>
                </div>
            </div>
            <div class="uk-width-1-1 uk-margin">
                <template v-if="success">
                    <div class="uk-alert-success" uk-alert>
                        <p>The promo code '{{submittedCode}}' will take {{discount_percent}}% off.</p>
                    </div>
                </template>
                <template v-if="fail">
                    <div class="uk-alert-danger" uk-alert>
                        <p>The promo code '{{submittedCode}}' wasn't found.</p>
                    </div>
                </template>
            </div>
            <div class="uk-margin-top">
                <h2>Registration Fee $<span id="price">{{(price - (price * (discount_percent * 0.01))).toFixed(2)}}</span></h2>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        name: "promoCode",
        props: ['price'],
        data: () => ({
            code: '',
            submittedCode: '',
            success: false,
            fail: false,
            discount_percent: 0
        }),
        mounted() {
            // The checkout button checks the code too, so show its result here like Apply does
            window.addEventListener('promo-code-checked', this.onPromoCodeChecked);
        },
        unmounted() {
            window.removeEventListener('promo-code-checked', this.onPromoCodeChecked);
        },
        methods: {
            checkPromoCode: function () {
                this.success = false;
                this.fail = false;
                this.discount_percent = 0;
                this.submittedCode = this.code;
                axios.post('/api/promo-code', {
                    code: this.code
                })
                .then((response) => {
                    this.showResult(this.code, response.data);
                })
                .catch((error) => {
                    this.showResult(this.code, 0);
                });
            },
            onPromoCodeChecked: function (event) {
                this.showResult(event.detail.code, event.detail.discountPercent);
            },
            showResult: function (code, discountPercent) {
                this.submittedCode = code;
                this.success = discountPercent > 0;
                this.fail = !this.success;
                this.discount_percent = this.success ? discountPercent : 0;
            }
        }
    }
</script>