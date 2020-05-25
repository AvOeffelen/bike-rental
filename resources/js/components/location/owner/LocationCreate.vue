<template>
    <div>

        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Voeg locatie(s) toe</h3>
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
                <div v-else>
                    <b-row v-if="errors != null">
                        <b-col>
                            <div class="block block-bordered">
                                <div class="block-header block-header-default">
                                    <h4 class="block-title">Er zijn fouten geconstateerd in het formulier.</h4>
                                    <div class="text-right">
                                        <b-button variant="block-option" data-toggle="block-option"
                                                  data-action="content_toggle">
                                            <i class="si si-arrow-up"></i>
                                        </b-button>
                                    </div>
                                </div>
                                <div class="block-content">
                                    <ul>
                                        <li class="text-danger" v-for="(error,index) in this.errors" :key="index">
                                            {{error[0]}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row class="items-push">
                        <b-col md="12" class="content-heading ">
                            <h4 class="pt-0">Contact persoon</h4>
                            <small class="text-muted mb-2">
                                De contact persoon zal een email ontvangen met een automatisch gegenereerd wachtwoord
                                waarmee hij/zij in kan loggen
                            </small>
                        </b-col>
                        <b-col md="5">
                            <label>Voornaam</label>
                            <b-input v-model="company.contact.name"
                                     class="form-control"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col md="2">
                            <label>Tussenvoegsel</label>
                            <b-input v-model="company.contact.name_addition"
                                     class="form-control"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col md="5">
                            <label>Achternaam</label>
                            <b-input v-model="company.contact.lastname"
                                     class="form-control"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col md="6">
                            <label>Email</label>
                            <b-input v-model="company.contact.email"
                                     class="form-control"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col md="6">
                            <label>Telefoonnummer</label>
                            <b-input v-model="company.contact.phone"
                                     class="form-control"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                    </b-row>
                    <b-row class="items-push">
                        <b-col md="12">
                            <div class="content-heading">
                                <b-row>
                                    <b-col>
                                        <h4 class="pt-0">vestiging</h4>
                                        <b-row>
                                            <b-col>
                                                <small class="text-muted mb-2">
                                                    Het is mogelijk om locaties achteraf toe te voegen.
                                                </small>
                                            </b-col>
                                            <b-col>
                                                <div class="text-right">
                                                    <b-button variant="alt-primary" size="sm"
                                                              @click="addExtraLocation()">add
                                                        location
                                                    </b-button>
                                                </div>
                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row v-for="(location,index) in this.company.locations" :key="index" class="location">
                        <b-col>
                            <div class="content-heading">
                                <b-row>
                                    <b-col>
                                        <p class="">Locatie {{index +1}}</p>
                                    </b-col>
                                    <b-col>
                                        <div class="text-right" v-if="company.locations.length <= 1">
                                            <b-button variant="alt-primary" size="sm" class="disabled" disabled>
                                                remove location
                                            </b-button>
                                        </div>
                                        <div class="text-right" v-else>
                                            <b-button variant="alt-primary" size="sm"
                                                      @click="removeLocation(index)">remove
                                                location
                                            </b-button>
                                        </div>
                                    </b-col>
                                </b-row>
                            </div>
                        </b-col>
                        <b-col md="12">
                            <label>Naam</label>
                            <b-input v-model="location.name"
                                     class="form-control input-field"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col md="8">
                            <label>Straat</label>
                            <b-input v-model="location.address"
                                     class="form-control input-field"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col md="2">
                            <label>Nummer</label>
                            <b-input v-model="location.number"
                                     class="form-control input-field"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
                        <b-col>
                            <label>postcode</label>
                            <b-input v-model="location.postalcode"
                                     class="form-control input-field"
                                     rows="4"
                                     placeholder="">
                            </b-input>
                        </b-col>
<!--                        TODO::Add this to the locations overview so the owners can easily make a workplace-->
                        <b-col md="12">
                            <span>
                                <div class="form-check">
                                    <span>
                                        <b-form-checkbox class="form-check-input" type="checkbox" v-model="company.is_workplace" id="example-checkbox-default1" label="Dit is een werkplaats" name="example-checkbox-default1">Dit is een werkplaats</b-form-checkbox>
                                    </span>
                                </div>
                            </span>
                        </b-col>
                    </b-row>
                    <b-row class="py-4">
                        <b-col sm="12" xl="12" md="12" lg="12" class="pr-2">
                            <div class="text-right">
                                <b-button variant="danger" size="sm" @click="resetForm">
                                    reset
                                </b-button>
                                <b-button variant="alt-primary" size="sm" @click="submit">
                                    save
                                </b-button>
                            </div>
                        </b-col>
                    </b-row>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    function formInitialState() {
        return {
            is_workplace:false,
            contact: {
                name: "",
                name_addition: '',
                lastname: "",
                email: "",
                phone: '',
            },
            locations: [
                {
                    name: '',
                    address: '',
                    number: '',
                    postalcode: '',
                }
            ]
        };
    }

    export default {
        name: "LocationCreate",
        data() {
            return {
                loading: true,
                company: {
                    is_workplace:false,
                    contact: {
                        name: "",
                        name_addition: '',
                        lastname: "",
                        email: "",
                        phone: '',
                    },
                    locations: [
                        {
                            name: '',
                            address: '',
                            number: '',
                            postalcode: '',
                        }
                    ]
                },
                errors: null
            }
        },
        created() {
            setTimeout(() => {
                this.loading = false;
            }, 1000)
        },
        methods: {
            resetForm() {
                Object.assign(this.company, formInitialState());
            },
            submit() {
                axios.post('axios/company/post', this.company)
                    .then(response => {
                        this.$root.$emit('updateLocations', response.data);
                        Object.assign(this.company, formInitialState());
                    })
                    .catch(error => {
                        console.log(error);
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
            },
            addExtraLocation(index) {
                console.log("clicked", this.company);
                let newx = {
                    name: '',
                    address: '',
                    number: '',
                    postalcode: '',
                };
                this.company.locations.push(newx);
            },
            removeLocation(index) {
                this.company.locations.splice(index, 1);
            }
        }
    }
    //#574a49
</script>

<style lang="scss" scoped>
    .location:nth-child(odd) {
        padding-top: 0.25rem !important;
    }

    .location .input-field:nth-child(odd) {
        padding-top: 0.25rem !important;
        border-color: #574a49 !important;
        background-color: #574a49 !important;
    }
</style>
