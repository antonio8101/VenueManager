<template>
    <div>
        <nav-bar v-on:itemclicked="show"></nav-bar>
        <div class="container-fluid">
            <div class="page-content extend-to-all-viewport">
                <venues v-if="visible==='venues'"></venues>
                <users v-if="visible==='users'"></users>
            </div>
        </div>
    </div>
</template>

<script>

    import NavBar from "./NavBarComponent";
    import Venues from "./VenuesComponent";
    import Users from "./UsersComponent";

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return{
                "visible" : 'venues'
            }
        },
        methods: {
            show : function(e) {
                this.visible = e[0];
            }
        },
        components: {
            NavBar,
            Venues,
            Users
        }
    }
</script>
