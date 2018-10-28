<template>
    <div id="venues_component" class="extend-to-all-viewport">
        <map-component></map-component>
        <venues-list-component></venues-list-component>
    </div>
</template>

<script>

    import MapComponent from "./venuesComponents/MapComponent.vue";
    import VenuesListComponent from "./venuesComponents/VenuesListComponent.vue";

    export default {
        name: "VenuesComponent",
        data() {
            return {
                //
            }
        },
        components: {
            MapComponent,
            VenuesListComponent
        }
    }

</script>