<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Bicycles</h3>
            </div>
            <div class="block-content">
                <div v-if="this.loading == true" class="text-center">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <table class="table table-striped table-borderless table-vcenter" v-else>
                    <thead class="bg-primary-dark text-light">
                    <tr>
                        <th style="width: 33%;">Frame number</th>
                        <th class="d-none d-sm-table-cell">available</th>
                        <th class="d-none d-sm-table-cell">in repair</th>
                        <th style="width: 33%;" class="d-sm-table-cell">leased</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bicycle,key) in this.bicycles.data" :key="key">
                        <td>
                            <div>
                                <span>{{bicycle.framenumber}}</span>
                            </div>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div>
                                <span v-if="bicycle.available == 0">Not available</span>
                                <span v-else>Available</span>
                            </div>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div>
                                <span v-if="bicycle.in_repair == 0">Not in repair</span>
                                <span v-else>In repair</span>
                            </div>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div v-if="bicycle.lease_start && bicycle.lease_end == null">
                                -
                            </div>
                            <div v-else>
                                <span>
                                    {{bicycle.lease_start}} - {{bicycle.lease_end}}
                                </span>
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="text-right">
                                <b-button variant="light" size="sm" class="btn-light"
                                          v-if="bicycle.requested_repair != 1"
                                          @click="initRequestRepairModal(bicycle)">
                                    <i class="fa fa-fw fa-wrench text-primary"></i>
                                </b-button>
                                <b-button :id="`popover-description-${index}`" variant="light" size="sm"
                                          class="btn-light disabled" v-else
                                          @click="initRequestRepairModal(bicycle)" disabled>
                                    <i class="fa fa-fw fa-wrench text-primary"></i>
                                </b-button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- END Posts Table -->

                <!-- Psts Pagincation -->
                <div v-if="this.bicycles == null"></div>
                <pagination v-else
                            class="pagination-margin"
                            size="small"
                            :data="bicycles"
                            @pagination-change-page="getBicycles">
                </pagination>
                <!-- END Posts Pagincation -->
            </div>
        </div>

        <b-modal v-model="requestRepair">
            <b-row v-if="errors != null">
                <b-col>
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h4 class="block-title">Er zijn fouten geconstateerd in het formulier.</h4>
                        </div>
                        <div class="block-content">
                            <ul>
                                <li class="text-danger" v-for="(error,index) in this.errors" :key="index">
                                    {{error[0]}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </b-col>
            </b-row>
            <b-row>
                <b-col class="">
                    <h3 class="block-title">Geselecteerde fiets:</h3>
                    <p v-if="bike_to_repair.bicycle.framenumber != null">
                        {{this.bike_to_repair.bicycle.framenumber}}</p>
                    <h4 class="block-title">Huur periode:</h4>
                    <p>{{this.bike_to_repair.bicycle.lease_start}} - {{ this.bike_to_repair.bicycle.lease_end}}</p>
                </b-col>
            </b-row>
            <b-row class="form-group form-row">
                <b-col sm="12" xl="12" md="12" lg="12">
                    <label>Omschrijving</label>
                    <b-textarea v-model="bike_to_repair.description"
                                class="form-control"
                                id="example-textarea-input"
                                name="example-textarea-input"
                                rows="4"
                                placeholder="Geef een korte omschrijving wat er gerepareerd dient te worden..">
                    </b-textarea>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-row class="pb-1">
                    <b-col sm="12" xl="12" md="12" lg="12">
                        <div class="text-right">
                            <b-button variant="danger" size="sm" @click="resetForm">
                                reset
                            </b-button>
                            <b-button variant="alt-primary" size="sm" @click="submitRepair">
                                save
                            </b-button>
                        </div>
                    </b-col>
                </b-row>
            </template>
        </b-modal>
    </div>
</template>

<script>
    function formInitialState() {
        return {
            description: ''
        };
    }


    function bikeInitialState() {
        return {
            description: '',
            bicycle: {}
        };
    }

    export default {
        name: "bicycleIndex",
        data() {
            return {
                loading: true,
                requestRepair: false,
                bike_to_repair: {
                    description: '',
                    bicycle: {}
                },
                errors: null,
                bicycles: {}
            };
        },
        created() {
            this.getBicycles();
        },
        methods: {
            getBicycles() {
                axios.get('/axios/location/all-bicycles/get').then(response => {
                    this.bicycles = response.data;
                    this.loading = false;
                })
            },
            resetForm() {
                Object.assign(this.bike_to_repair.description, formInitialState());
            },
            initRequestRepairModal(bicycle) {
                this.requestRepair = true;
                this.bike_to_repair.bicycle = bicycle;
            },
            submitRepair() {
                axios.post('/axios/repair/request', this.bike_to_repair)
                    .then(response => {
                        Object.assign(this.bike_to_repair, bikeInitialState());
                        this.requestRepair = false;
                        this.getBicycles();
                    })
                    .catch(error => {
                        console.log(error);
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
            },
        }
    }
</script>

<style scoped>

</style>
