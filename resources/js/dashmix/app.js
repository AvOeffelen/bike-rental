import './bootstrap';
require('../polyfills');
window.Popper = require('popper.js').default;

window.Vue = require('vue');
import Multiselect from 'vue-multiselect'

import { createPopper } from '@popperjs/core';

Vue.component('bicycle-index',require('../components/bicycles/bicycleIndex.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('repair-index',require('../components/repair/repairIndex').default);
Vue.component('bicycle-timeline',require('../components/bicycles/timeline/bicycleTimeline').default);
Vue.component('location-owner-index',require('../components/location/owner/LocationIndex').default);
Vue.component('profile-edit',require('../components/profile/profileEdit').default);
Vue.component('sign-up',require('../components/auth/signup').default);
Vue.component('location-manager-index',require('../components/location/manager/LocationIndex').default);
Vue.component('multiselect',Multiselect);
Vue.component('location-overview',require('../components/location/LocationOverview').default);
Vue.component('location-manager-overview',require('../components/location/manager/locationOverview').default);
Vue.component('location-mechanic-overview',require('../components/location/mechanic/LocationOverview').default);
Vue.component('location-mechanic-index',require('../components/location/mechanic/LocationIndex').default);
Vue.component('user-index',require('../components/users/UserIndex').default);
Vue.component('owner-dashboard',require('../components/dashboard/OwnerDashboard').default);
Vue.component('location-manager-dashboard',require('../components/dashboard/LocationManagerDashboard').default);
Vue.component('location-manager-bicycle-index',require('../components/bicycles/locationManager/bicycleIndex').default);
Vue.component('mechanic-dashboard',require('../components/dashboard/MechanicDashboard').default);

import Toast from "vue-toastification";

import "vue-toastification/dist/index.css";
const options = {
    timeout: 2000,
    position: 'top-right'
};

Vue.use(Toast, options);

import VueFlatPickr from 'vue-flatpickr-component';
Vue.use(VueFlatPickr);

import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';

Vue.use(BootstrapVue);
Vue.use(createPopper);

Vue.filter('truncate', function (text, length, suffix) {
    if (text.length > length) {
        return text.substring(0, length) + suffix;
    } else {
        return text;
    }
});

const app = new Vue({
    el: '#main-container',
    components: {
    },
});

// Import required modules
import Tools from './modules/tools';
import Helpers from './modules/helpers';
import Template from './modules/template';
import {from} from "bootstrap-vue/esm/utils/array";

// App extends Template
export default class App extends Template {
    /*
     * Auto called when creating a new instance
     *
     */
    constructor() {
        super();
    }
}

// Once everything is loaded
jQuery(() => {
    // Create a new instance of App
   window.Dashmix = new App();
});
