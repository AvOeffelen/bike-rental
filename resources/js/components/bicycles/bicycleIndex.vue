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
                <div v-else>
                    <div v-if="errors.length !== 0">
                        <b-row>
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
                    </div>
                    <div v-else>
                    </div>
                    <table class="table table-striped table-borderless table-vcenter">
                        <thead class="bg-primary-dark text-light">
                        <tr>
                            <th class="d-none d-sm-table-cell">Frame number</th>
                            <th class="d-none d-sm-table-cell">Beschikbaarheid</th>
                            <th class="d-none d-sm-table-cell">Reparatie status</th>
                            <th class="d-sm-table-cell">Locatie</th>
                            <th class="d-sm-table-cell">Leased</th>
                            <th style="width: 200px;" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <b-form-input v-model="new_bicycle.framenumber" placeholder="12345DF459" type="text"
                                              autocomplete="false"
                                              class="form-control form-control"></b-form-input>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                Beschikbaar
                            </td>
                            <td class="d-none d-sm-table-cell">
                                Niet in reparatie
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                            <td class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" @click="submitForm(bicycle)">
                                    <i class="fa fa-fw fa-check text-primary"></i>
                                </b-button>
                            </td>
                        </tr>
                        <tr v-for="(bicycle,key) in this.bicycles.data" :key="key">
                            <td>
                                <div v-if="isEditing.currently == true && isEditing.key == key">
                                    <b-form-input v-model="bicycle.framenumber" placeholder="12345DF459" type="text"
                                                  class="form-control form-control"></b-form-input>
                                </div>
                                <div v-else>
                                    <span>{{bicycle.framenumber}}</span>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <div v-if="isEditing.currently == true && isEditing.key == key">
                                    <b-form-select v-model="bicycle.available"
                                                   v-if="bicycle.lease_start && bicycle.lease_end == null"
                                                   class="custom-select form-control form-control"
                                                   :options="options"></b-form-select>
                                    <b-form-select v-model="bicycle.available" v-else
                                                   class="custom-select form-control form-control disabled" disabled
                                                   :options="options"></b-form-select>
                                </div>
                                <div v-else>
                                    <span v-if="bicycle.available == 0">Niet beschikbaar</span>
                                    <span v-else>Beschikbaar</span>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span v-if="bicycle.in_repair == 0">Niet in reparatie</span>
                                <span v-else>In reparatie</span>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <span v-if="bicycle.location == null">-</span>
                                <span v-else>{{bicycle.location.name}}</span>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <div v-if="bicycle.lease_start && bicycle.lease_end == null">
                                    -
                                </div>
                                <div v-else>
                                    <div v-if="isEditing.currently == true && isEditing.key == key">
                                        <div v-if="bicycle.lease_start && bicycle.lease_end != null">
                                        <span class="date-pickrr">
                                        {{bicycle.lease_start}}
                                        </span>
                                            -
                                            <span class="date-pickrr">
                                            <flat-pickr
                                                v-model="bicycle.lease_end"
                                                :config="config"
                                                class="form-control"
                                                placeholder="Select date"
                                                name="lease_end"></flat-pickr>
                                        </span>
                                        </div>
                                        <div v-else>
                                            <span>-</span>
                                        </div>
                                    </div>
                                    <span v-else>
                                    {{bicycle.lease_start}} - {{bicycle.lease_end}}
                                </span>
                                </div>
                            </td>
                            <td class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" v-if="bicycle.available == 1"
                                          @click="initTransferBicycleModal(bicycle,key)">
                                    <i class="fa fa-fw fa-exchange-alt text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light" v-else
                                          @click="initTransferBicycleBackModal(bicycle,key)">
                                    <i class="fa fa-fw fa-arrow-left text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light"
                                          @click="updateBicycle(bicycle,key)"
                                          v-if="isEditing.currently == true && isEditing.key == key">
                                    <i class="fa fa-fw fa-check text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light"
                                          @click="initEditBicycle(bicycle,key)"
                                          v-else>
                                    <i class="fa fa-fw fa-pencil-alt text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light"
                                          @click="cancelEditing(bicycle,key)"
                                          v-if="isEditing.currently == true && isEditing.key == key">
                                    <i class="fa fa-fw fa-times text-danger"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light"
                                          @click="removeBicycle(bicycle,key)"
                                          v-else>
                                    <i class="fa fa-fw fa-trash text-danger"></i>
                                </b-button>
                                <!--                            <b-button variant="light" size="sm" class="btn-light">-->
                                <!--                                <i class="fa fa-fw fa-search text-primary"></i>-->
                                <!--                            </b-button>-->
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-if="this.bicycles == null"></div>
                    <pagination v-else
                                class="pagination-margin"
                                size="small"
                                :data="bicycles"
                                @pagination-change-page="getBicycles">
                    </pagination>
                </div>
            </div>
        </div>
        <b-modal v-model="addToLocationModal" size="lg" title="Fiets verhuren">
            <b-row>
                <b-col class="">
                    <h3 class="block-title">Geselecteerde fiets:</h3>
                    <p v-if="bicycleTransferInformation.bicycle != null">
                        {{this.bicycleTransferInformation.bicycle.framenumber}}</p>
                </b-col>
            </b-row>
            <b-row v-if="errors2.length !== 0">
                <b-col>
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h4 class="block-title">Er zijn fouten geconstateerd in het formulier.</h4>
                            <div class="text-right">
                                <b-button variant="block-option" data-toggle="block-option"
                                          data-action="content_toggle">
                                    <i class="si si-arrow-up"></i>
                                </b-button>
                            </div>
                        </div>
                        <div class="block-content">
                            <ul>
                                <li class="text-danger" v-for="(error,index) in this.errors2" :key="index">
                                    {{error[0]}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </b-col>
            </b-row>
            <b-row>
                <b-col class="">
                    <h3 class="block-title">Nieuwe locatie:</h3>
                </b-col>
            </b-row>
            <label for="select_bike">Selecteer locatie</label>
            <multiselect v-model="bicycleTransferInformation.location"
                         class="select_bike"
                         :options="locations"
                         :preselect-first="true"
                         placeholder="Select location"
                         label="name"
                         id="select_bike"
                         track-by="name">
            </multiselect>
            <b-row class="py-2">
                <b-col>
                    <label for="date-start">Start datum</label>
                    <flat-pickr
                        v-model="bicycleTransferInformation.start"
                        :config="config"
                        class="custom-select form-control form-control"
                        placeholder="Select date"
                        name="date">
                    </flat-pickr>
                </b-col>
                <b-col>
                    <label for="date-end">Eind datum</label>
                    <flat-pickr
                        v-model="bicycleTransferInformation.end"
                        :config="config"
                        class="custom-select form-control form-control"
                        placeholder="Select date"
                        name="date">
                    </flat-pickr>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-button size="sm" variant="danger" @click="cancelTransferBicycle">cancel</b-button>
                <b-button variant="alt-primary" size="sm" @click="transferBicycle"> save</b-button>
            </template>
        </b-modal>
        <b-modal v-model="cancelLeaseModal" size="lg" title="Lease cancelen">
            <p>Wil je deze fiets terug halen naar BEZORGFIETS? Je maakt de fiets dan weer toegankelijk om te verhuren
                aan andere locaties.</p>
            <template v-slot:modal-footer>
                <b-button size="sm" variant="danger" @click="closeCancelLeaseModal">Cancel</b-button>
                <b-button variant="alt-primary" size="sm" @click="transferBicycleBack()">Transfer</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    function initErrorState() {
        return [];
    }

    function initialState() {
        return {
            framenumber: '',
            available: 1,
            in_repair: 0
        };
    }

    function initialBikeTransferState() {
        return {
            bicycle: null,
            location: null,
            start: null,
            end: null
        };
    }

    import flatPickr from 'vue-flatpickr-component';

    import {Dutch} from 'flatpickr/dist/l10n/nl.js';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        name: "bicycleIndex",
        data() {
            return {
                config: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'd-m-Y',
                    altInput: true,
                    dateFormat: 'd-m-Y',
                    locale: Dutch,
                },
                new_bicycle: {
                    framenumber: '',
                    available: 1,
                    in_repair: 0,
                    lease_start: '',
                    lease_end: ''
                },
                options: [
                    {value: 1, text: "yes"},
                    {value: 0, text: "no"}
                ],
                bicycles: {},
                loading: true,
                isEditing:
                    {
                        currently: false,
                        key: null
                    },
                errors: [],
                errors2: [],
                addToLocationModal: false,
                bicycleTransferInformation: {
                    bicycle: null,
                    location: null,
                    start: null,
                    end: null
                },
                locations: [],
                cancelLeaseModal: false,
            };
        },
        created() {
            setTimeout(() => {
                this.loading = false;
                this.getBicycles();
                this.getLocations();
                this.getLocations();
            }, 1000);
        },
        mounted() {
        },
        methods: {
            closeCancelLeaseModal() {
                this.cancelLeaseModal = false;
                Object.assign(this.bicycleTransferInformation, initialBikeTransferState());
            },
            cancelTransferBicycle() {
                this.addToLocationModal = false;
                Object.assign(this.bicycleTransferInformation, initialBikeTransferState());
                Object.assign(this.errors, initErrorState());

            },
            initTransferBicycleBackModal(bicycle) {
                this.cancelLeaseModal = true;
                this.bicycleTransferInformation = bicycle;
            },
            getLocations() {
                axios.get('axios/location/get').then(response => {
                    this.locations = response.data
                });
            },
            initTransferBicycleModal(bicycle, index) {
                this.addToLocationModal = true;
                this.bicycleTransferInformation.bicycle = bicycle;
            },
            transferBicycleBack() {
                axios.post('axios/bicycle/transfer-back', this.bicycleTransferInformation)
                    .then(response => {
                        for (let b in this.bicycles.data) {
                            if (this.bicycles.data[b].id == response.data.id) {
                                this.bicycles.data[b] = response.data;
                            }
                        }
                        Object.assign(this.bicycleTransferInformation, initialBikeTransferState());
                        this.cancelLeaseModal = false;
                    });
            },
            transferBicycle() {
                axios.post('axios/bicycle/transfer', this.bicycleTransferInformation)
                    .then(response => {
                        this.addToLocationModal = false;
                        for (let b in this.bicycles.data) {
                            if (this.bicycles.data[b].id == response.data.id) {
                                this.bicycles.data[b] = response.data;
                            }
                        }
                        Object.assign(this.bicycleTransferInformation, initialBikeTransferState());
                        Object.assign(this.errors2, initErrorState());
                    })
                    .catch(error => {
                        console.log(error);
                        if (error.response.status == 422) {
                            this.errors2 = error.response.data.errors;
                        }
                    });
            },
            submitForm() {
                let url = variables.post_bicycles;
                axios.post(url, this.new_bicycle)
                    .then(response => {
                        this.bicycles.data.push(response.data);
                        Object.assign(this.new_bicycle, initialState());
                        this.errors = [];
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
            },
            getBicycles(page = 1) {
                let url = variables.paginate_bicycles;
                axios.get(url + '?page=' + page)
                    .then(response => {
                        this.bicycles = response.data;
                    });
            },
            initEditBicycle(bicycle, key) {
                this.isEditing.currently = true;
                this.isEditing.key = key;

                this._beforeEditingCache = bicycle;
                this._beforeEditingCache = Object.assign({}, bicycle);
            },
            cancelEditing(bicycle, key) {

                Object.assign(this.bicycles.data[key], this._beforeEditingCache);
                this._beforeEditingCache = null;

                this.isEditing.currently = false;
                this.isEditing.key = null;
            },
            updateBicycle(bicycle, key) {
                let url = variables.update_bicycle.format(bicycle.id);
                axios.put(url, bicycle)
                    .then(response => {
                        for (let b in this.bicycles.data) {
                            if (b === key) {
                                this.bicycles.data[b] = bicycle;
                            }
                        }
                        this._beforeEditingCache = null;
                        this.isEditing.currently = false;
                        this.isEditing.key = null;
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        }
                    });

            },
            removeBicycle(bicycle, key) {
                let url = variables.remove_bicycle.format(bicycle.id);
                axios.delete(url).then(response => {
                    this.bicycles.data.splice(key, 1);
                    if (this.bicycles.data.length == 0) {
                        this.getBicycles();
                    }
                });
            },
        }
    }
</script>

<style scoped>
    .date-pickrr .input {
        background-color: #ffffff;
    }
</style>
