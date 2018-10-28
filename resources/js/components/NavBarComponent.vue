<template>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">

        <a class="navbar-brand" href="#" aria-expanded="false">Venue Manager</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/"  data-toggle="collapse" data-target=".navbar-collapse.show">Home</a>
                </li>


                <!-- TODO : TO BE ACTIVATED -->

                <li class="nav-item">
                    <a class="nav-link" v-on:click="menuItemClicked( 'venues' )" data-toggle="collapse" data-target=".navbar-collapse.show">Sedi</a>
                </li>
                <!--<li class="nav-item">-->
                    <!--<a class="nav-link" v-on:click="menuItemClicked( 'users' )" data-toggle="collapse" data-target=".navbar-collapse.show">Operatori</a>-->
                <!--</li>-->


                <!--<li class="nav-item dropdown">-->
                    <!--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--Dropdown-->
                    <!--</a>-->
                    <!--<div class="dropdown-menu" aria-labelledby="navbarDropdown">-->
                        <!--<a class="dropdown-item" href="#">Action</a>-->
                        <!--<a class="dropdown-item" href="#">Another action</a>-->
                        <!--<div class="dropdown-divider"></div>-->
                        <!--<a class="dropdown-item" href="#">Something else here</a>-->
                    <!--</div>-->
                <!--</li>-->
                <li class="nav-item">
                    <a class="nav-link" href="/logout" data-target=".navbar-collapse.hidden">
                        Logout
                    </a>
                </li>
            </ul>

        </div>
    </nav>
</template>

<script>
    export default {
        name: "NavBar",
        methods: {
            menuItemClicked : function(e) {

                this.$emit('itemclicked', [ e ])

            }
        }
    }
</script>

<style scoped>

</style>