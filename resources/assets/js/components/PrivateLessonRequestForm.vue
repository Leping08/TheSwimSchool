<template>
    <div>
        <div class="uk-margin">
            <label class="uk-form-label uk-heading-bullet" for="location">Location</label>
            <div class="uk-form-controls">
                <select class="uk-select" name="location" id="location" v-model="selected">
                    <option value="The Swim School Pool">The Swim School Pool</option>
                    <option value="My Home or Community Pool">My Home or Community Pool</option>
                </select>
            </div>
        </div>
        <div class="uk-margin" v-if="selected === 'The Swim School Pool'">
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
                <input type="text" name="address" value="" class="uk-input" placeholder="12345 Street Lakewood Ranch, FL 34202" required>
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
    //TODO: Keep error's in form
    export default {
        name: "PrivateLessonRequestForm.vue",
        props: [
            'oldAvailability',
            'oldAddress'
        ],
        data() {
            return {
                selected: "The Swim School Pool"
            }
        }
    }
</script>

<style scoped>

</style>