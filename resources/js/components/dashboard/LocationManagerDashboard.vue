<template>
    <div>
        <b-row>
            <b-col md="6" xl="6" class="invisible" data-toggle="appear">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div
                        class="block-content block-content-full d-flex align-items-center justify-content-between text-primary">
                        <div>
                            <i class="fa fa-4x fa-building"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-muted mb-0">
                                Locaties
                            </p>
                            <p class="font-size-h3 mb-0">
                                {{this.counters.locations}}
                            </p>
                        </div>
                    </div>
                </a>
            </b-col>
            <b-col md="6" xl="6" class="invisible" data-toggle="appear">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div
                        class="block-content block-content-full d-flex align-items-center justify-content-between text-primary">
                        <div>
                            <i class="fa fa-4x fa-bicycle"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-muted mb-0">
                                Fietsen
                            </p>
                            <p class="font-size-h3 mb-0">
                                {{this.counters.bikes}}
                            </p>
                        </div>
                    </div>
                </a>
            </b-col>
        </b-row>
        <div class="row row-deck">
            <div class="col-xl-6 invisible" data-toggle="appear">
                <!-- Users -->
                <div class="block block-rounded block-mode-loading-refresh">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Locaties</h3>
                        <div class="block-options">
                            <b-button variant="light" size="sm" class="btn-light text-primary" data-toggle="click-ripple"
                                      @click="getLocations">
                                <i class="si si-refresh"></i>
                            </b-button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="text-center" v-if="this.locations.length <= 0 && this.locationLoading == true">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm" v-else>
                            <thead>
                            <tr class="text-uppercase">
                                <th class="font-w700">Naam</th>
                                <th class="d-none d-sm-table-cell font-w700"># fietsen</th>
                                <th class="font-w700 text-center" style="width: 60px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(location,index) in this.locations" :key="index">
                                <td>
                                    <span class="font-w600">{{location.name}}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">{{location.bicycle_count}}</span>
                                </td>
                                <td class="text-center">
                                    <b-button data-toggle="tooltip" data-placement="top" title="Bekijken"
                                              variant="light" size="sm" class="btn-light" @click="loadLocation(location)">
                                        <i class="fa fa-fw fa-search text-primary"></i>
                                    </b-button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <b-row class="py-2">
                            <b-col>
                                <div class="text-right">
                                    <b-button variant="light" size="sm" class="btn-light text-primary"
                                              data-toggle="click-ripple"  @click="checkLocations">
                                        Bekijken
                                    </b-button>
                                </div>
                            </b-col>
                        </b-row>
                    </div>
                </div>
                <!-- END Users -->
            </div>
            <div class="col-xl-6 invisible" data-toggle="appear" data-timeout="200">
                <!-- Purchases -->
                <div class="block block-rounded block-mode-loading-refresh">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Fietsen</h3>
                        <div class="block-options">
                            <b-button variant="light" size="sm" class="btn-light text-primary" data-toggle="click-ripple"
                                      @click="getBicycles">
                                <i class="si si-refresh"></i>
                            </b-button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="text-center" v-if="this.bicycles.length <= 0 && this.bicyclesLoading == true">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm" v-else>
                            <thead>
                            <tr class="text-uppercase">
                                <th class="font-w700">Frame nummer</th>
                                <th class="d-none d-sm-table-cell font-w700">Lease</th>
                                <th class="font-w700 text-center" style="width: 60px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(bicycle,index) in this.bicycles" :key="index">
                                <td>
                                    <span class="font-w600">{{bicycle.framenumber}}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">{{bicycle.lease_start}} - {{bicycle.lease_end}}</span>
                                </td>
                                <td class="text-center">
<!--                                    <b-button data-toggle="tooltip" data-placement="top" title="Bekijken"-->
<!--                                              variant="light" size="sm" class="btn-light">-->
<!--                                        <i class="fa fa-fw fa-search text-primary"></i>-->
<!--                                    </b-button>-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <b-row class="py-2">
                            <b-col>
                                <div class="text-right">
                                    <b-button variant="light" size="sm" class="btn-light text-primary"
                                              data-toggle="click-ripple" @click="checkBicycles">
                                        Bekijken
                                    </b-button>
                                </div>
                            </b-col>
                        </b-row>
                    </div>
                </div>
                <!-- END Purchases -->
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LocationManagerDashboard",
        data() {
            return {
                locations: [],
                locationLoading: true,
                bicycles: [],
                bicyclesLoading: true,
                counters:[]
            };
        },
        created() {
            this.getLocations();
            this.getBicycles();
            this.getCounters();
        },
        methods: {
            getLocations() {
                axios.get('axios/dashboard/location/get').then(response => {
                    this.locations = response.data;
                    this.locationLoading = false;
                });
            },
            getBicycles(){
                axios.get('axios/dashboard/bicycle/get').then(response => {
                    this.bicycles = response.data;
                    this.bicyclesLoading = false;
                });
            },
            getCounters(){
                axios.get('axios/dashboard/counters/get').then(response => {
                    this.counters = response.data;
                });
            },
            checkLocations(){
                let url = '/location';
                window.location = url;
            },
            checkBicycles(){
                let url = '/bicycles';
                window.location = url;
            },
            loadLocation(location){
                let url = '/location/'+location.id
                window.location = url;
            }
        }
    }
</script>

<style scoped>

</style>
