<template>
    <div>
        <b-row>
            <b-col>
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
                            <tr v-for="(bicycle,key) in this.bicycles" :key="key">
                                <td>
                                    <div>
                                        <span>{{bicycle.bicycle.framenumber}}</span>
                                    </div>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <div>
                                        <span :id="`popover-description-${key}`">{{bicycle.description | truncate('35','...')}}</span>
                                        <b-popover :target="`popover-description-${key}`" triggers="hover" placement="top">
                                            <template v-slot:title>Omschrijving</template>
                                            {{bicycle.description}}
                                        </b-popover>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <b-button variant="light" size="sm" class="btn-light"
                                              @click="acceptRepair(bicycle,key)">
                                        <i class="fa fa-fw fa-check text-primary"></i>
                                    </b-button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import RequestRepair from "./requestRepair";

    export default {
        name: "repairIndex",
        components: {RequestRepair},
        data(){
          return {
            bicycles:[],
          };
        },
        created() {
            this.getBicyclesCurrentlyInRepair();
        },
        methods: {
            acceptRepair(bicycle){
              axios.post('axios/repair/accept',bicycle).then( response =>{
                    this.getBicyclesCurrentlyInRepair();
              });
            },
            // getBicycles() {
            //     axios.get('axios/bicycle/list/get').then(response => {
            //         this.bicycles = response.data;
            //     });
            // },
            getBicyclesCurrentlyInRepair() {
                axios.get('axios/repair/in-repair/get').then(response => {
                    this.bicycles = response.data;
                });
            }
        },
    }
</script>

<style scoped>

</style>
