<template>
    
</template>

<script>
    export default {
        name: "UserDataLoaderComponent",
        data() {
          return {
              sessionToken : null
          }
        },
        methods : {
            loadData: function() {

                const context = this;

                const instance =  this.$root.axios.create({
                    baseURL: '/',
                    timeout: 1000,
                    headers: {'Authorization': 'Bearer ' + this.$store.state.sessionToken}
                });

                return instance.get('api/user/get/1').then(function (response) {
                    const user = response.data.data;
                    context.$store.commit('setUser', user);

                }).catch(function (error) {
                    console.log("Errore" + error);

                });

            }
        },
        created(){
            this.loadData();
        }
    }
</script>

<style scoped>

</style>