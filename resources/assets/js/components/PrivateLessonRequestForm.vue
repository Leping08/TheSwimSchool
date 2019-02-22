<template>
    <div>
        <div class="uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="">Location</label>
            <div class="uk-form-controls">
                <select class="uk-select" name="location" id="location" v-model="selected">
                    <option value="Harrison Ranch">Harrison Ranch</option>
                    <option value="River Wilderness Golf & Country Club">River Wilderness Golf & Country Club</option>
                    <option value="My Home or Community Pool">My Home or Community Pool (Provide Address Below)</option>
                </select>
            </div>
        </div>
        <div class="uk-margin" v-if="selected === 'Harrison Ranch'">
            <div class="uk-form-controls">
                <!--TODO Adjust the color of this checkbox-->
                <label><input class="uk-checkbox" type="checkbox" name="hr_resident">
                    Are you a Harrison Ranch resident?
                </label>
            </div>
        </div>
        <div class="uk-margin" v-if="selected === 'My Home or Community Pool'">
            <label class="uk-form-label uk-heading-bullet" for="">Address</label>
            <div class="uk-form-controls">
                <input type="text" name="Address" value="" class="uk-input" placeholder="12345 Street Lakewood Ranch, FL 34202">
            </div>
        </div>
        <div class="uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="">Provide us with your availability</label>
            <div class="uk-form-controls">
                <textarea name="availability" rows="5" class="uk-textarea" placeholder="Example: I am available Monday from 8am-1pm and Wednesday from 5-9pm." required></textarea>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PrivateLessonRequestForm.vue",
        data() {
            return {
                selected: "Harrison Ranch"
            }
        }
    }
</script>

<style scoped>

</style>