<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Aanvragen voor reparatie</h3>
                <div class="text-right">
                    <b-button variant="block-option" class="btn-block-option" data-toggle="block-option"
                              data-action="content_toggle"></b-button>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="bg-primary-dark text-light">
                    <tr>
                        <th style="width: 33%;">Frame number</th>
                        <th class="d-none d-sm-table-cell">description</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bicycle,key) in this.bicyclesRequestedRepair" :key="key">
                        <td>
                            <div>
                                <span>{{bicycle.bicycle.framenumber}}</span>
                            </div>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div>
                                <span
                                    :id="`popover-description-${key}`">{{bicycle.description | truncate('35','...')}}</span>
                                <b-popover :target="`popover-description-${key}`" triggers="hover" placement="top">
                                    <template v-slot:title>Omschrijving</template>
                                    {{bicycle.description}}
                                </b-popover>
                            </div>
                        </td>
                        <td class="text-right">
                            <b-button variant="light" size="sm" class="btn-light"
                                      @click="acceptRepairModal(bicycle,key)">
                                <i class="fa fa-fw fa-check text-primary"></i>
                            </b-button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal v-model="acceptRepairRequestModal">
            <b-row>
                <b-col md="12">
                            <span>
                                <div class="form-check">
                                    <span>
                                        <b-form-checkbox class="form-check-input" type="checkbox"
                                                         v-model="replacement" id="no_contact_person"
                                                         label="Ik wil deze fiets vervangen" name="no_contact_person"
                                                         @change="replacementBicycle()">
                                            Ik wil de fiets die voor reparatie opgegeven is vervangen.
                                        </b-form-checkbox>
                                    </span>
                                </div>
                            </span>
                </b-col>
            </b-row>
            <b-row class="pt-3" v-if="replacement == true">
                <b-col>
                    <label for="select_bike">Selecteer fiets ter vervanging</label>
                    <multiselect v-model="bicycle_info.bicycle_replacement"
                                 class="select_bike"
                                 :options="bicycles"
                                 :preselect-first="true"
                                 placeholder="Select replacement bicycle"
                                 label="framenumber"
                                 id="select_bike"
                                 track-by="framenumber">
                    </multiselect>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-button size="danger" data-toggle="click-ripple" @click="closeModal">cancel</b-button>
                <b-button size="alt-primary" data-toggle="click-ripple" @click="acceptRepair">add</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import RequestRepair from "./requestRepair";

    export default {
        name: "repairIndex",
        components: {RequestRepair},
        data() {
            return {
                bicycles: [],
                bicycle_info:{
                    bicycle:null,
                    bicycle_replacement:null,
                },
                bicyclesRequestedRepair: [],
                acceptRepairRequestModal:false,
                replacement:true
            };
        },
        created() {
            this.getBicyclesCurrentlyInRepair();
            this.getBicycles();
        },
        methods: {
            closeModal(){
              this.replacement = true;
              this.acceptRepairRequestModal = false;
              this.bicycle_info.bicycle_replacement = null;
            },
            replacementBicycle(){
                this.replacement = !this.replacement;
                if(this.replacement == false){
                    this.bicycle_info.bicycle_replacement = null;
                    console.log(this.bicycle_info.bicycle_replacement);
                }
            },
            acceptRepairModal(bicycle){
                this.acceptRepairRequestModal = true;
                this.bicycle_info.bicycle = bicycle;
            },
            acceptRepair() {
                axios.post('axios/repair/accept', this.bicycle_info).then(response => {
                    this.getBicyclesCurrentlyInRepair();
                    this.closeModal();
                });
            },
            // getBicycles() {
            //     axios.get('axios/bicycle/list/get').then(response => {
            //         this.bicycles = response.data;
            //     });
            // },
            getBicyclesCurrentlyInRepair() {
                axios.get('axios/repair/in-repair/get').then(response => {
                    this.bicyclesRequestedRepair = response.data;
                });
            },
            getBicycles(){
                axios.get('/axios/bicycle/available/get').then(response => {
                   this.bicycles = response.data;
                });
            }
        },
    }
</script>

<style scoped>

</style>
