<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{location.name}}</h3>
                <div class="text-right">
                    <b-button variant="block-option" class="btn-block-option" data-toggle="block-option"
                              data-action="content_toggle"></b-button>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="bg-primary-dark text-light">
                    <tr>
                        <th style="width: 33%;">Frame nummer</th>
                        <th style="width: 33%;">huur periode</th>
                        <th style="width: 200px;" class="text-right">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bicycle,index) in location.bicycle" :key="index">
                        <td>{{bicycle.framenumber}}</td>
                        <td>
                                <span v-if="bicycle.lease_start && bicycle.lease_end !== null">
                                    {{bicycle.lease_start}} - {{ bicycle.lease_end}}
                                </span>
                            <span v-else>
                                    -
                                </span>
                        </td>
                        <td>
                            <div class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" v-if="bicycle.requested_repair != 1"
                                          @click="initRequestRepairModal(bicycle)">
                                    <i class="fa fa-fw fa-wrench text-primary"></i>
                                </b-button>
                                <b-button :id="`popover-description-${index}`" variant="light" size="sm" class="btn-light disabled" v-else
                                          @click="initRequestRepairModal(bicycle)" disabled>
                                    <i class="fa fa-fw fa-wrench text-primary"></i>
                                </b-button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
        name: "locationOverview",
        props: [
            'location'
        ],
        data() {
            return {
                requestRepair: false,
                bike_to_repair: {
                    description: '',
                    bicycle: {}
                },
                errors: null,
            };
        },
        created() {

        },
        methods: {
            resetForm() {
                Object.assign(this.bike_to_repair.description, formInitialState());
            },
            initRequestRepairModal(bicycle) {
                this.requestRepair = true;
                this.bike_to_repair.bicycle = bicycle;
            },
            getBicycles(){
              axios.get('/axios/location/'+this.location.id+'/get-bicycles').then( response => {
                  this.location.bicycle = response.data;
              });
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
