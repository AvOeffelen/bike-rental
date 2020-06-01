<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Locaties</h3>
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
                        <th style="width: 33%;">naam</th>
                        <th class="d-none d-sm-table-cell">aantal fietsen</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(location,index) in this.locations" :key="index">
                            <td class="d-none d-sm-table-cell">
                                {{location.name}}
                            </td>
                            <td class="d-none d-sm-table-cell">
                                {{location.bicycle_count}}
                            </td>
                            <td class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" @click="loadLocation(location)">
                                    <i class="fa fa-fw fa-search text-primary"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LocationIndex",
        data(){
            return{
                locations:[],
                loading:true,
            };
        },
        created() {
            this.getLocations();
        },
        methods:{
            loadLocation(location){
                let url = '/location/'+location.id
                window.location = url;
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
