<template>
    <div>

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Fietsenmaker</h3>
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
                        <th class="d-none d-sm-table-cell">Beschrijving</th>
                        <th class="d-none d-sm-table-cell">Word gemaakt</th>
                        <th class="d-none d-sm-table-cell">Start reparatie</th>
                        <th style="width: 200px;" class="text-right">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bicycle,index) in this.bicycles" :key="index">
                        <td>{{bicycle.bicycle.framenumber}}</td>
                        <td>
                            <span
                                :id="`popover-description-${index}`">{{bicycle.description | truncate('35','...')}}</span>
                            <b-popover :target="`popover-description-${index}`" triggers="hover" placement="top">
                                <template v-slot:title>Omschrijving</template>
                                {{bicycle.description}}
                            </b-popover>
                        </td>
                        <td>
                                <span v-if="bicycle.in_progress == 0">
                                    Nee
                                </span>
                            <span v-else>
                                    Ja
                                </span>
                        </td>
                        <td>
                                <span v-if="bicycle.started_at != null">
                                    {{bicycle.started_at}}
                                </span>
                            <span v-else>
                                    -
                                </span>
                        </td>
                        <td>
                            <div class="text-right">
                                    <span v-if="bicycle.in_progress == 1">
                                        <b-button variant="light" size="sm" class="btn-light"
                                                  @click="initBicycleFinish(bicycle)">
                                            <i class="fa fa-fw fa-check text-primary"></i>
                                        </b-button>
                                    </span>
                                <span v-else>
                                        <b-button variant="light" size="sm" class="btn-light"
                                                  @click="setBicycleInRepairInProgress(bicycle)">
                                            <span class="text-primary">start</span>
                                        </b-button>
                                    </span>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal v-model="finishRepairModal">
            <div v-if="tempBicycle.bicycle != null">
                <b-row>
                    <b-col class="">
                        <h3 class="block-title">Geselecteerde fiets:</h3>
                        <p>{{this.tempBicycle.bicycle.bicycle.framenumber}}</p>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col class="">
                        <h3 class="block-title">Probleem:</h3>
                        <p>{{this.tempBicycle.bicycle.description}}</p>
                    </b-col>
                </b-row>
                <b-row class="form-group form-row">
                    <b-col sm="12" xl="12" md="12" lg="12">
                        <label>Description</label>
                        <b-textarea v-model="tempBicycle.description"
                                    class="form-control"
                                    id="example-textarea-input"
                                    name="example-textarea-input"
                                    rows="4"
                                    placeholder="Geef een korte omschrijving wat er gerepareerd is...">
                        </b-textarea>
                    </b-col>
                </b-row>
            </div>
            <template v-slot:modal-footer>
                <b-button size="sm" variant="danger" @click="closeFinishRepairModal">Cancel</b-button>
                <b-button variant="alt-primary" size="sm" @click="finishBicycleRepair()">Transfer</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "LocationIndex",
        data() {
            return {
                locations: [],
                bicycles: {},
                tempBicycle: {
                    description: '',
                    bicycle: null
                },
                finishRepairModal: false,
            };
        },
        created() {
            setTimeout(() => {
                this.getBicyclesInRepairGranted();
            }, 1000);

        },
        methods: {
            closeFinishRepairModal() {
                this.tempBicycle.description = '';
                this.tempBicycle.bicycle = null;
                this.finishRepairModal = false;
            },
            initBicycleFinish(bicycle) {
                this.finishRepairModal = true;
                this.tempBicycle.bicycle = bicycle;
            },
            getLocations() {
                axios.get('axios/location/get').then(response => {
                    this.locations = response.data
                    this.loading = false;
                });
            },
            getBicyclesInRepairGranted() {
                axios.get('axios/repair/bicycles/repair-granted')
                    .then(response => {
                        this.bicycles = response.data;
                    });
            },
            setBicycleInRepairInProgress(bicycle) {
                axios.post('axios/repair/bicycle/start-repair', bicycle)
                    .then(response => {
                        this.getBicyclesInRepairGranted();
                    });
            },
            finishBicycleRepair(bicycle) {
                axios.post('axios/repair/bicycle/finish-repair', this.tempBicycle)
                    .then(response => {
                        this.getBicyclesInRepairGranted();
                        this.closeFinishRepairModal();
                    });
            }
        }
    }
</script>

<style scoped>

</style>
