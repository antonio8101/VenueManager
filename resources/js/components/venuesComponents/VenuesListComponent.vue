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
            <div class="list-group">
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
        </div>
    </div>
</template>

<script>
    export default {
        name: "VenuesListComponent",
        data() {
          return {
              venues : [
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  },
                  {
                      name : "Nome della Venue",
                      address : {
                          description : "via dal tali 1, 20100 Milano ITA"
                      }
                  }
              ]
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
                console.log(this.$store.state.user.firstname);
            }
        },
        created(){
            console.log("Venues list component knows about store : " + this.$store.state.count);
            this.$store.commit('setUser', {
                "firstname" : "test",
                "lastname" : "test"
            });
        }
    }
</script>
<style scoped>

    #venue-list-component {
        height: 100%;
    }

</style>
