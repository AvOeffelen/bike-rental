<template>
<!--    TODO:: remove this at all.-->
    <div>
        <company-create></company-create>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Locaties</h3>
                <div class="text-right">
                    <b-button variant="block-option" class="btn-block-option" data-toggle="block-option"
                              data-action="content_toggle"></b-button>
                </div>
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
                        <th style="width: 33%;">Naam</th>
                        <thd></thd>
                        <th style="width: 200px;" class="text-center">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(location,index) in this.locations" :key="index">
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import CompanyCreate from "./CompanyCreate";
    export default {
        name: "CompanyIndex",
        components: {CompanyCreate},
        data(){
            return{
                loading:true,
                locations:[]
            };
        },
        created() {
            setTimeout( ()=>{
                this.loading = false;
            },5000)
        },
        mounted(){
            this.$root.$on('updateLocations',(locations)=>{
                this.updateLocationsList(locations);
            });
        },
        methods:{
            updateLocationsList(locations){
                for(let x in locations){
                    this.locations.push(locations[x]);
                }
            }
        }
    }
</script>

<style scoped>

</style>
