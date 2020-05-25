<template>
    <div>
        <location-create></location-create>
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
                        <th>Aantal fietsen</th>
                        <th style="width: 200px;" class="text-center">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(location,index) in this.locations" :key="index">
                        <td>{{location.name}}</td>
                        <td>TBD</td>
                        <td>
                            <div class="text-right">
                                <b-button variant="light" size="sm" class="btn-light">
                                    <i class="fa fa-fw fa-search text-primary"></i>
                                </b-button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import LocationCreate from "./LocationCreate";
    export default {
        name: "LocationIndex",
        components: {LocationCreate},
        data(){
            return{
                loading:true,
                locations:[]
            };
        },
        created() {
            setTimeout( ()=>{
                this.loading = false;
                this.getLocations();
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
            },
            getLocations(){
                axios.get('axios/location/get').then(response => {
                    this.locations = response.data
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>

</style>
