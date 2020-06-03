<template>
    <div>
        <b-row>
            <b-col md="4" xl="4" class="invisible" data-toggle="appear">
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
            <b-col md="4" xl="4" class="invisible" data-toggle="appear">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div
                        class="block-content block-content-full d-flex align-items-center justify-content-between text-primary">
                        <div>
                            <i class="fa fa-4x fa-wrench"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-muted mb-0">
                                In reparatie
                            </p>
                            <p class="font-size-h3 mb-0">
                                {{this.counters.repairsCurrently}}
                            </p>
                        </div>
                    </div>
                </a>
            </b-col>
            <b-col md="4" xl="4" class="invisible" data-toggle="appear">
                <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                    <div
                        class="block-content block-content-full d-flex align-items-center justify-content-between text-primary">
                        <div>
                            <i class="fa fa-4x fa-check"></i>
                        </div>
                        <div class="ml-3 text-right">
                            <p class="text-muted mb-0">
                                Repartie voltooid
                            </p>
                            <p class="font-size-h3 mb-0">
                                {{this.counters.repairsFinished}}
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
                        <h3 class="block-title">Reparatie aanvragen</h3>
                        <div class="block-options">
<!--                            TODO:: fix button-->
                            <b-button variant="light" size="sm" class="btn-light text-primary" data-toggle="click-ripple"
                                      @click="getBicyclesRequestedRepair">
                                <i class="si si-refresh"></i>
                            </b-button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="text-center" v-if="this.bicyclesRequestedRepair.length <= 0 && this.bicyclesRequestedRepairLoading == true">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm" v-else>
                            <thead>
                            <tr class="text-uppercase">
                                <th class="font-w700">Frame nummer</th>
                                <th class="d-none d-sm-table-cell font-w700">Omschrijving</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(bicycle,index) in this.bicyclesRequestedRepair" :key="index">
                                <td>
                                    <span class="font-w600">{{bicycle.bicycle.framenumber}}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">

                                    <span :id="`popover-description-${index}`">{{bicycle.description | truncate('10','...')}}</span>
                                    <b-popover :target="`popover-description-${index}`" triggers="hover" placement="top">
                                        <template v-slot:title>Omschrijving</template>
                                        {{bicycle.description}}
                                    </b-popover>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <b-row class="py-2">
                            <b-col>
                                <div class="text-right">
                                    <b-button variant="light" size="sm" class="btn-light text-primary"
                                              data-toggle="click-ripple" @click="goToRepairRequests">
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
                        <h3 class="block-title">Momenteel in reparatie</h3>
                        <div class="block-options">
                            <b-button variant="light" size="sm" class="btn-light text-primary" data-toggle="click-ripple"
                                      @click="getBicyclesRequestedRepair">
                                <i class="si si-refresh"></i>
                            </b-button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="text-center" v-if="this.bicycleCurrentlyRepair.length <= 0 && this.bicycleCurrentlyRepairLoading == true">
                            <div class="spinner-grow text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm" v-else>
                            <thead>
                            <tr class="text-uppercase">
                                <th class="font-w700">Frame nummer</th>
                                <th class="d-none d-sm-table-cell font-w700">Start datum</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(bicycle,index) in this.bicycleCurrentlyRepair" :key="index">
                                <td>
                                    <span class="font-w600">{{bicycle.bicycle.framenumber}}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">{{bicycle.started_at}}</span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <b-row class="py-2">
                            <b-col>
                                <div class="text-right">
                                    <b-button variant="light" size="sm" class="btn-light text-primary"
                                              data-toggle="click-ripple" @click="">
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
        name: "MechanicDashboard",
        data() {
            return {
                locations: [],
                locationLoading: true,
                bicyclesRequestedRepair: [],
                bicyclesRequestedRepairLoading: true,
                bicycleCurrentlyRepair:[],
                bicycleCurrentlyRepairLoading:true,
                counters: []
            };
        },
        created() {
            this.getBicyclesRequestedRepair();
            this.getBicyclesCurrentlyInRepair();
            this.getCounters();
        },
        methods: {
            getBicyclesRequestedRepair(){
                axios.get('axios/repair/bicycles/repair-granted').then(response => {
                    this.bicyclesRequestedRepair = response.data;
                    this.bicyclesRequestedRepairLoading = false;
                });
            },
            getBicyclesCurrentlyInRepair(){
                axios.get('axios/repair/bicycles/repair-in-progress/get').then(response => {
                   this.bicycleCurrentlyRepair = response.data;
                   this.bicycleCurrentlyRepairLoading = false;
                });
            },
            getCounters() {
                axios.get('axios/dashboard/counters/get').then(response => {
                    this.counters = response.data;
                });
            },
            checkLocations() {
                let url = '/location';
                window.location = url;
            },
            checkBicycles() {
                let url = '/bicycles';
                window.location = url;
            },
            loadLocation(location) {
                let url = '/location/' + location.id
                window.location = url;
            },
            goToRepairRequests(){
                let url = '/repair';
                window.location = url;
            }
        }
    }
</script>

<style scoped>

</style>
