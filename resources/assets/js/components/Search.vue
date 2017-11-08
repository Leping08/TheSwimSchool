<template>
    <div class="uk-card uk-card-default">
        <div class="uk-card-header">
            <form>
                <div class="uk-margin">
                    <div class="uk-inline uk-width-1-1">
                        <span class="uk-form-icon" uk-icon="icon: search"></span>
                        <input class="uk-input" type="text" v-model="search" placeholder="Swimmer Name">
                    </div>
                </div>
            </form>
        </div>

        <div class="uk-card-body">
            <ul class="uk-list uk-list-striped">
                <li><strong>Swimmers</strong></li>
                <li v-for="swimmer in filteredArticles"><a v-bind:href="'/swimmers/'+swimmer.id" class="list-group-item list-group-item-action justify-content-between">
                    {{swimmer.name}}

                </a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['allswimmers'],
        mounted() {
            console.log('mounted')
        },
        data() {
            return {
               swimmers: this.allswimmers,
               search: ''
            }
        },
        computed: {
        // A computed property that holds only those articles that match the searchString.
            filteredArticles: function () {
                var swimmers_object = this.swimmers,
                    searchString = this.search;

                if(!searchString){
                    return swimmers_object;
                }

                searchString = searchString.trim().toLowerCase();

                swimmers_object = swimmers_object.filter(function(item){
                    if(item.name.toLowerCase().indexOf(searchString) !== -1){
                        return item;
                    }
                })

                // Return an array with the filtered data.
                return swimmers_object;
            }
        },
    }
</script>


<style>
.primary-blue{
    background-color: #0275d8!important;
}

.white{
    color: white;
}
</style>