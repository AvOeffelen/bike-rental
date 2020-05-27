
// Import global dependencies
import './bootstrap';
require('../polyfills');
window.Popper = require('popper.js').default;

window.Vue = require('vue');
import Multiselect from 'vue-multiselect'

import { createPopper } from '@popperjs/core';

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('test',require('../components/Test.vue').default);
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

    /*
     *  Here you can override or extend any function you want from Template class
     *  if you would like to change/extend/remove the default functionality.
     *
     *  This way it will be easier for you to update the module files if a new update
     *  is released since all your changes will be in here overriding the original ones.
     *
     *  Let's have a look at the _uiInit() function, the one that runs the first time
     *  we create an instance of Template class or App class which extends it. This function
     *  inits all vital functionality but you can change it to fit your own needs.
     *
     */

    /*
     * EXAMPLE #1 - Removing default functionality by making it empty
     *
     */

    //  _uiInit() {}


    /*
     * EXAMPLE #2 - Extending default functionality with additional code
     *
     */

    //  _uiInit() {
    //      // Call original function
    //      super._uiInit();
    //
    //      // Your extra JS code afterwards
    //  }

    /*
     * EXAMPLE #3 - Replacing default functionality by writing your own code
     *
     */

    //  _uiInit() {
    //      // Your own JS code without ever calling the original function's code
    //  }
}

// Once everything is loaded
jQuery(() => {
    // Create a new instance of App
   window.Dashmix = new App();
});
