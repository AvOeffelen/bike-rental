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
                        <th style="width: 33%;">Is werkplaats</th>
                        <th>Aantal fietsen</th>
                        <th style="width: 200px;" class="text-center">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(location,index) in this.locations" :key="index">
                        <td>{{location.name}}</td>
                        <td>
                            <span v-if="location.is_workplace == 1">
                                Ja
                            </span>
                            <span v-else>
                                Nee
                            </span>
                        </td>
                        <td>{{location.bicycle_count}}</td>
                        <td>
                            <div class="text-right">
                                <b-button variant="light" size="sm" class="btn-light"
                                          @click="initLinkLocationModal(location)" v-if="location.managed_by == null"
                                          data-toggle="tooltip" data-placement="top" title="Link locatie aan gebruiker">
                                    <i class="fa fa-fw fa-paperclip text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light" @click="loadLocation(location)">
                                    <i class="fa fa-fw fa-search text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light"
                                          @click="initRemoveLocationModal(location)">
                                    <i class="fa fa-fw fa-trash text-primary"></i>
                                </b-button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal v-model="linkLocationModal">
            <b-row>
                <b-col md="12">
                    <h3 class="block-title">Geselecteerde locatie:</h3>
                    <p v-if="linkLocation.location != null">
                        {{this.linkLocation.location.name}}</p>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="12">
                    <label>Selecteer locatie manager</label>
                    <multiselect v-model="linkLocation.manager"
                                 class="select_bike"
                                 :options="users"
                                 :preselect-first="true"
                                 placeholder="Select manager"
                                 label="name"
                                 track-by="name">
                    </multiselect>
                </b-col>
            </b-row>
            <template v-slot:modal-footer>
                <b-button size="sm" variant="danger" @click="closeLinkLocationModal">Cancel</b-button>
                <b-button variant="alt-primary" size="sm" @click="linkLocationx">submit</b-button>
            </template>
        </b-modal>
        <b-modal v-model="removeLocationModal">
            <div v-if="tempLocation != null">
                <p>Weet je zeker dat je {{this.tempLocation.name}} wilt verwijderen?</p>
            </div>
            <template v-slot:modal-footer>
                <b-button size="sm" variant="danger" @click="closeLocationRemovalModal">Cancel</b-button>
                <b-button variant="alt-primary" size="sm" @click="removeLocation">submit</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import LocationCreate from "./LocationCreate";

    export default {
        name: "LocationIndex",
        components: {LocationCreate},
        data() {
            return {
                loading: true,
                locations: [],
                linkLocationModal: false,
                users: {},
                linkLocation: {
                    manager: null,
                    location: null
                },
                removeLocationModal: false,
                tempLocation: null
            };
        },
        created() {
            this.getLocations();
            this.getManagers();
        },
        mounted() {
            this.$root.$on('updateLocations', (locations) => {
                this.updateLocationsList(locations);
            });
        },
        methods: {
            removeLocation() {
                let url = 'axios/location/'+this.tempLocation.id+'/delete';
                axios.delete(url)
                    .then(response => {
                        this.getLocations();
                        this.closeLocationRemovalModal();
                        this.$toast.success("Locatie succesvol verwijderd!");
                    });
            },
            initRemoveLocationModal(location) {
                this.removeLocationModal = true;
                this.tempLocation = location;
            },
            linkLocationx() {
                axios.post('axios/location/link', this.linkLocation)
                    .then(response => {
                        this.getLocations();
                        this.linkLocationModal = false
                    });
            },
            closeLocationRemovalModal() {
                this.removeLocationModal = false;
                this.tempLocation = null;
            },
            closeLinkLocationModal() {
                this.linkLocationModal = false
            },
            initLinkLocationModal(location) {
                this.linkLocationModal = true;
                this.linkLocation.location = location;
            },
            updateLocationsList(locations) {
                for (let x in locations) {
                    this.locations.push(locations[x]);
                }
            },
            getLocations() {
                axios.get('axios/location/get').then(response => {
                    this.locations = response.data
                    this.loading = false;
                })
            },
            getManagers() {
                axios.get('axios/location/managers/get').then(response => {
                    this.users = response.data
                })
            },
            loadLocation(location) {
                let url = '/location/' + location.id
                window.location = url;
            }
        }
    }
</script>

<style scoped>

</style>
