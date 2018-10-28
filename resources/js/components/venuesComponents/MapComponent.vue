<template>
    <div id="map-component">

            <GmapMap :center = center :zoom = zoom :options = mapOptions :click="mapClicked">
                <GmapMarker
                        :key="index"
                        v-for="(m, index) in markers"
                        :position="m.position"
                        :clickable="true"
                        :draggable="false"
                        @click="venueMarkerClicked"


                />
            </GmapMap>

    </div>
</template>

<script>
    export default {
        name: "MapComponent",
        data() {
            return {
                center: { lat: 45.46251198, lng: (9.197144 + 0.05) },
                markers: [],
                zoom: 12,
                places: [],
                mapOptions :  {
                    disableDefaultUI : true
                },
                currentPlace: null
            }
        },
        methods : {
            venueMarkerClicked : function (marker) {

                this.center = {
                    lat : marker.latLng.lat(),
                    lng : marker.latLng.lng()
                };

                console.log('venue marker clicked at position lat<'+marker.latLng.lat()+'> lng<'+marker.latLng.lng()+'>')

            },
            mapClicked : function (event) {

                console.log(event);

            },
            getMarkers : function () {
                return [{
                    position : {
                        lat: 45.46251198,
                        lng: 9.197144
                    }
                },
                    {
                        position : {
                            lat: 45.46251198,
                            lng: 9.197144
                        }
                    }]
            }
        },
        created() {

            console.log("Map Created");
            this.markers = this.getMarkers();

        }
    }
</script>

<style scoped>

    #map-component {
        width: 100px;
        height: 100px;
    }
    #map-component,
    #map-component * {
        height: 100%;
        width: 100%;
    }


</style>