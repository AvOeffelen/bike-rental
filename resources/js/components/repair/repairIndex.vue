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
                        <th style="width: 33%;">Frame nummer</th>
                        <th class="d-none d-sm-table-cell">Omschrijving</th>
                        <th class="d-none d-sm-table-cell">Locatie</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bicycle,key) in this.bicyclesRequestedRepair" :key="key">
                        <td>
                            <div>
                                <span>{{ bicycle.bicycle.framenumber }}</span>
                            </div>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <div>
                                <span
                                    :id="`popover-description-${key}`">{{
                                        bicycle.description | truncate('35','...')
                                    }}</span>
                                <b-popover :target="`popover-description-${key}`" triggers="hover" placement="top">
                                    <template v-slot:title>Omschrijving</template>
                                    {{ bicycle.description }}
                                </b-popover>
                            </div>
                        </td>
                        <td>
                            <div>
                                <span v-if="bicycle.bicycle.location != null">{{ bicycle.bicycle.location.name }}</span>
                                <span v-else>-</span>
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
        <b-modal v-model="acceptRepairRequestModal" @close="resetRepairRequestModal()">
            <b-row>
                <b-col md="12">
                            <span>
                                <div class="form-check">
                                    <span>
                                        <b-form-checkbox class="form-check-input" type="checkbox"
                                                         v-model="bicycle_info.replacement" id="no_contact_person"
                                                         label="Ik wil deze fiets vervangen" name="no_contact_person"
                                                         @change="replacementBicycle()">
                                            Ik wil de fiets die voor reparatie opgegeven is vervangen.
                                        </b-form-checkbox>
                                    </span>
                                </div>
                            </span>
                </b-col>
            </b-row>
            <b-row class="pt-3" v-if="bicycle_info.replacement == true && bicycle_info.fixOnLocation == false">
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
            <b-row class="pt-3" v-if="bicycle_info.replacement == false">
                <b-col>
                    <div class="form-check">
                        <span>
                            <b-form-checkbox class="form-check-input" type="checkbox"
                                             v-model="bicycle_info.fixOnLocation" id="fix_on_location"
                                             label="Ik wil deze fiets vervangen" name="fix_on_location"
                                             @change="fixedOnLocation()">
                                De fiets word gerepareert op locatie.
                            </b-form-checkbox>
                        </span>
                    </div>
                </b-col>
            </b-row>
            <b-row v-if="bicycle_info.fixOnLocation == true && bicycle_info.replacement == false">
                <b-col>
                    <label for="select_bike">Omschrijving gedane reparatie.</label>
                    <b-textarea v-model="bicycle_info.repair_description"
                                class="form-control"
                                id="example-textarea-input"
                                name="example-textarea-input"
                                rows="4"
                                placeholder="Geef een korte omschrijving van de reparatie.">
                    </b-textarea>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-button size="danger" data-toggle="click-ripple" @click="closeModal">cancel</b-button>
                <b-button size="alt-primary" data-toggle="click-ripple" @click="acceptRepair">accept</b-button>
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
            bicycle_info: {
                bicycle: null,
                bicycle_replacement: null,
                repair_description: null,
                replacement: true,
                fixOnLocation: false
            },
            bicyclesRequestedRepair: [],
            acceptRepairRequestModal: false,
        };
    },
    created() {
        this.getBicyclesCurrentlyInRepair();
        this.getBicycles();
    },
    methods: {
        resetRepairRequestModal() {
            this.bicycle_info.bicycle = null;
            this.bicycle_info.bicycle_replacement = null;
            this.bicycle_info.replacement = true;
            this.bicycle_info.fixOnLocation = false;
        },
        fixedOnLocation() {
            this.bicycle_info.fixOnLocation = !this.bicycle_info.fixOnLocation;
        },
        closeModal() {
            this.bicycle_info.replacement = true;
            this.acceptRepairRequestModal = false;
            this.bicycle_info.bicycle_replacement = null;
        },
        replacementBicycle() {
            this.bicycle_info.replacement = !this.bicycle_info.replacement;
            if (this.bicycle_info.replacement == false) {
                this.bicycle_info.bicycle_replacement = null;
            }
        },
        acceptRepairModal(bicycle) {
            this.acceptRepairRequestModal = true;
            this.bicycle_info.bicycle = bicycle;
        },
        acceptRepair() {
            axios.post('axios/repair/accept', this.bicycle_info).then(response => {
                this.replacement = true;
                this.fixOnLocation = false;
                this.getBicyclesCurrentlyInRepair();
                this.closeModal();
            });
        },
        getBicyclesCurrentlyInRepair() {
            axios.get('axios/repair/in-repair/get').then(response => {
                this.bicyclesRequestedRepair = response.data;
            });
        },
        getBicycles() {
            axios.get('/axios/bicycle/available/get').then(response => {
                this.bicycles = response.data;
            });
        }
    },
}
</script>

<style scoped>

</style>
