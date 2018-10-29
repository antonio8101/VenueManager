<template>
    <div id="venues_component" class="extend-to-all-viewport">
        <map-component></map-component>
        <venues-list-component :list="venues"></venues-list-component>
    </div>
</template>

<script>

    import MapComponent from "./venuesComponents/MapComponent.vue";
    import VenuesListComponent from "./venuesComponents/VenuesListComponent.vue";

    export default {
        name: "VenuesComponent",
        data() {
            return {
                userId : null,
                venues : [],
                loading : false,
            }
        },
        methods : {
            getUserVenues : function() {

                this.loading = true;

                const userId = this.$store.state.user.id;



                const context = this;

                const instance =  this.$root.axios.create({
                    baseURL: '/',
                    timeout: 5000,
                    headers: {'Authorization': 'Bearer ' + this.$store.state.sessionToken}
                });

                return instance.post('api/venue/search', {
                    'user_id' : userId
                }).then(function (response) {
                    context.venues = response.data.data.items;
                    context.loading = false;

                }).catch(function (error) {
                    console.log("Errore" + error);
                    context.loading = false;

                });


            }
        },
        created() {
          console.log("retrieving user venues");

            this.$store.watch(this.$store.getters.getUser, user => {
                this.userId = user.id;
                this.getUserVenues();
            });
        },
        watch : {
            userId : function (v) {

            }
        },
        components: {
            MapComponent,
            VenuesListComponent
        }
    }

</script>