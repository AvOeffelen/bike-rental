<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Request repair</h3>
                <div class="text-right">
                    <b-button variant="block-option" class="btn-block-option" data-toggle="block-option"
                              data-action="content_toggle"></b-button>
                </div>
            </div>
            <div class="block-content">
                <b-row class="form-group form-row">
                    <b-col sm="12" xl="12" md="12" lg="12">
                        <label>Select bicycle</label>
                        <multiselect
                            class=""
                            v-model="bicycle.bicycle"
                            :options="bicycles"
                            :close-on-select="true"
                            placeholder="Select bicycle"
                            label="framenumber"
                            track-by="framenumber"
                        ></multiselect>
                    </b-col>
                </b-row>
                <b-row class="form-group form-row">
                    <b-col sm="12" xl="12" md="12" lg="12">
                        <label>Description</label>
                        <b-textarea v-model="bicycle.description"
                                    class="form-control"
                                    id="example-textarea-input"
                                    name="example-textarea-input"
                                    rows="4"
                                    placeholder="Geef een korte omschrijving wat er gerepareerd dient te worden..">
                        </b-textarea>
                    </b-col>
                </b-row>
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
            </div>
        </div>
    </div>
</template>

<script>
    function initialState() {
        return {
                bicycle:{
                },
                description:''
        }
    }
    export default {
        name: "requestRepair",
        data() {
            return {

                options: [
                    {value: 1, text: "yes"},
                    {value: 0, text: "no"}
                ],
                bicycle: {
                    bicycle:{
                    },
                    description:''
                },
                bicycles:[],
            };
        },
        created() {
            this.getBicycles();
        },
        methods: {
            getBicycles() {
                axios.get('axios/bicycle/list/get')
                    .then(response => {
                        console.log("response",response.data);
                    this.bicycles = response.data;
                });
            },
            submitRepair(){
              axios.post('axios/repair/request',this.bicycle)
                  .then(response =>{

              });
            },
            resetForm(){
                Object.assign(this.bicycle,initialState());
            }
        },
    }
</script>

<style scoped>

</style>
