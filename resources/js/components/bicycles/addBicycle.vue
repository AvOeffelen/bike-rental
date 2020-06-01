<template>
    <!--    TODO:: remove this at all.-->
    <div>
        <b-modal class="modal-dialog modal-dialog-pop-in mb-0 modal-backdrop" v-model="modal" v-if="initModal == true" @hidden="closeModal" size="lg">
            <template v-slot:modal-header >
                <h5 class="modal-title">Modal Title</h5>
            </template>
            <b-row class="form-group form-row">
                <b-col sm="12" xl="12" md="12" lg="12">
                    <label>Frame Number</label>
                    <b-form-input v-model="new_bicycle.framenumber" placeholder="12345DF459" type="text" class="form-control form-control-alt"></b-form-input>
                </b-col>
            </b-row>
            <b-row class="form-group form-row">
                <b-col sm="12" xl="12" md="12" lg="12">
                    <label>Available</label>
                    <b-form-select v-model="new_bicycle.available" class="custom-select form-control form-control-alt" :options="options"></b-form-select>
                </b-col>
            </b-row>
            <b-row class="form-group form-row">
                <b-col sm="12" xl="12" md="12" lg="12">
                    <label>In repair</label>
                    <b-form-select v-model="new_bicycle.in_repair" class="custom-select form-control form-control-alt" :options="options"></b-form-select>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-button size="danger" data-toggle="click-ripple" @click="closeModal">cancel</b-button>
                <b-button size="alt-primary" data-toggle="click-ripple" @click="submitForm">add</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    function initialState() {
        return {
            new_bicycle:{
                framenumber:'',
                available:1,
                in_repair:0
            },
        }
    }
    export default {
        name: "addBicycle",
        props: [
            'initModal'
        ],
        data() {
            return {
                modal: true,
                new_bicycle:{
                    framenumber:'',
                    available:1,
                    in_repair:0
                },
                options:[
                    {value:1,text:"yes"},
                    {value:0,text:"no"}
                ],
            };
        },
        created() {
        },
        methods: {
            closeModal() {
                this.modal = !this.modal;
                this.$emit('closeModal');
                Object.assign(this.new_bicycle,initialState());
            },
            submitForm(){
                let url = variables.post_bicycles;
                console.log(url);
                axios.post(url,this.new_bicycle)
                    .then( response =>{
                        this.$root.$emit('updateBicycles',this.new_bicycle);
                        this.closeModal();
                    });
            }
        }
    }
</script>

<style>
 /*.modal-backdrop{*/
 /*    opacity: 0.5;*/
 /*}*/
</style>
