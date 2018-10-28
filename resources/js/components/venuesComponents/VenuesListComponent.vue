<template>
    <div id="venue-list-component">
        <div id="venue-list-component-uplist">
            <div id="venue-list-component-title">
                <h1>SEDI</h1>
            </div>
            <div id="venue-list-component-actions">
                <a id="add-venue" @click="addVenue"><i class="fas fa-plus">&nbsp;</i> AGGIUNGI</a>
            </div>
            <div id="venue-list-component-search" class="search-bar">
                <input type="text" placeholder="Nome, Citta, Indirizzo" />
            </div>
        </div>
        <div id="venue-list-component-list">
            <div id="wait">
                <div class="list-group" v-if="venues.length">
                    <a href="#" class="list-group-item list-group-item-action flex-column align-items-start"
                       v-for="venue in venues" @click="venueClicked">
                        <div class="d-flex w-100 justify-content-between">
                            <span class="circle-icon"><i class="fa fa-warehouse fa-5x"></i></span>
                            <h5 class="mb-1">{{venue.name}}</h5>
                            <!--<small class="text-muted">30 operatori</small>-->
                        </div>
                        <small class="text-muted">{{venue.address.description}}</small>
                    </a>
                </div>
                <div class="no-results" v-else-if="loading">
                    <PulseLoader :loading="loading" :color="color" :size="size"></PulseLoader>
                </div>
                <div class="no-results" v-else>
                    Nessun risultato
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PulseLoader from "vue-spinner/src/PulseLoader";
    export default {
        name: "VenuesListComponent",
        components: {PulseLoader},
        data() {
          return {
              venues : [],
              loading : false,
              color : "#16AA8C",
              size : "15px"
          }
        },
        methods: {
            venueClicked : function(venue){
                console.log("add venue");
                this.$store.commit('increment');
                console.log('incremented store ' +  this.$store.state.count);
            },
            addVenue : function () {
                console.log("add venue");
                this.$store.commit('increment');
                console.log('incremented store ' +  this.$store.state.count);
                console.log(this.$store.state.user);
            }
        },
        created(){
            console.log("Venues list component knows about store : " + this.$store.state.count);
        }
    }
</script>
<style scoped>

    #venue-list-component {
        height: 100%;
    }

</style>
