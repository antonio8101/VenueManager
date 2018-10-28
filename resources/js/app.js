
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import Vuex from 'vuex'
import * as VueGoogleMaps from 'vue2-google-maps'
//import BootstrapVue from 'bootstrap-vue'
//import 'bootstrap/dist/css/bootstrap.css'
//import 'bootstrap-vue/dist/bootstrap-vue.css'

//library.add(faCoffee, faBars, faSignOutAlt);

Vue.config.productionTip = false;

//Vue.use(BootstrapVue);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('main-component', require('./components/MainComponent.vue'));
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyDiCScNSVT8dlgU-o8Iu0oxPTbs9Q4x9PM',
        libraries: 'places', // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)

        //// If you want to set the version, you can do so:
        // v: '3.26',
    },

    //// If you intend to programmatically custom event listener code
    //// (e.g. `this.$refs.gmap.$on('zoom_changed', someFunc)`)
    //// instead of going through Vue templates (e.g. `<GmapMap @zoom_changed="someFunc">`)
    //// you might need to turn this on.
    /** autobindAllEvents: false, */

    //// If you want to manually install components, e.g.
    //// import {GmapMarker} from 'vue2-google-maps/src/components/marker'
    //// Vue.component('GmapMarker', GmapMarker)
    //// then disable the following:
    /** installComponents: true */
});
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        count: 0,
        user: {}
    },
    mutations: {
        increment (state) {
            state.count++
        },
        setUser (state, user) {
            state.user = user;
        }

    }
});

const app = new Vue({
    el: '#app',
    store,
});
