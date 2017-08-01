<template>
    <!--<div class="card" v-model="lesson">
        <div class="card-block">
            <form class="mt-3" action="" method="POST">
                <input type="hidden" name="_token" :value="csrf">
                <h4>Swimmer Infomation</h4>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="name">Swimmer Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="age">Swimmer Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Age" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="parent">Name of Parent/Guardian (if applicable)</label>
                        <input type="text" class="form-control" id="parent" name="parent" placeholder="Parent/Guardian">
                    </div>
                </div>
                <hr>
                <h4>Adress</h4>
                <div class="form-group">
                    <label for="street">Street</label>
                    <input type="address" class="form-control" id="street" name="street" placeholder="Street" required>
                </div>
                <div class="row">
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="city">City</label>
                        <input type="city" class="form-control" id="city" name="city" placeholder="City" required>
                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="state">State</label>
                        <input type="state" class="form-control" id="state" name="state" placeholder="State" required>
                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="zip">Zip Code</label>
                    <input type="numbers" class="form-control" id="zip" name="zip" placeholder="Zip Code" required>
                    </div>
                </div>
                <hr>
                <h4>Contact Infomation</h4>
                <div class="row">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                    </div>
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <hr>
                <h4>Emergency Contact Infomation</h4>
                <div class="row">
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="emergencyName">Emergency Contact Name</label>
                        <input type="text" class="form-control" id="emergencyName" name="emergencyName" placeholder="Name" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="emergencyRelationship">Emergency Contact Relationship</label>
                        <input type="text" class="form-control" id="emergencyRelationship" name="emergencyRelationship" placeholder="Relationship" required>
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="emergencyPhone">Emergency Phone Number</label>
                        <input type="tel" class="form-control" id="emergencyPhone" name="emergencyPhone" placeholder="Phone" required>
                    </div>
                </div>
                <hr>
                <h4>Price ${{lesson.price}}</h4>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="payment">Payment Method</label>
                        <select class="form-control custom-select" name="payment" id="payment" v-model="selected" required>
                            <option value="check">Cash or Check (In Person)</option>
                            <option value="card">Card (Online)</option>
                        </select>
                    </div>
                </div>



                <div class="row">
                    <div class="form-group col-sm-12">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" value="" name="Terms and Conditions" required>
                                    I agree to the <a :href="'/lessons/'+lesson.class_type+'/'+lesson.id+'/terms'" target="_blank">Group Swim Lesson Policies & Procedures</a>
                            </label>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>-->
</template>

<script>
    export default {
        props: ['lesson'],

        created() {
            
        },
        data() {
            return {
                csrf: "",
                selected: 'check',
            }
        },

        mounted() {
            console.log(window.Laracasts.csrfToken)
            this.csrf = window.Laracasts.csrfToken
        }
    }
</script>
