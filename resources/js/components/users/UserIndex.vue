<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Gebruiker uitnodigen</h3>
                <div class="text-right">
                    <b-button variant="block-option" class="btn-block-option" data-toggle="block-option"
                              data-action="content_toggle"></b-button>
                </div>
            </div>
            <div class="block-content">
                <b-row class="items-push">
                    <b-col md="12" class="content-heading">
                        <h4 class="pt-0">Contact persoon</h4>
                        <small class="text-muted mb-2">
                            De contact persoon zal een email ontvangen met een uitnodiging om te registreren bij
                            BEZORGFIETS. Zodra hij/zij deze geaccepteerd heeft zullen deze locaties aan hij/zij
                            gekoppeld worden.
                        </small>
                    </b-col>
                    <b-col md="12">
                        <label>Gebruiker type</label>
                        <b-form-select v-model="contact.type" :options="options" class="form-control"></b-form-select>
                    </b-col>
                    <b-col md="6">
                        <label>Voornaam</label>
                        <b-input v-model="contact.name"
                                 class="form-control"
                                 rows="4"
                                 placeholder="">
                        </b-input>
                    </b-col>
                    <b-col md="6">
                        <label>Achternaam</label>
                        <b-input v-model="contact.lastname"
                                 class="form-control"
                                 rows="4"
                                 placeholder="">
                        </b-input>
                    </b-col>
                    <b-col>
                        <label>Email</label>
                        <b-input v-model="contact.email"
                                 class="form-control"
                                 rows="4"
                                 placeholder="">
                        </b-input>
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
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Gebruikers</h3>
                <div class="text-right">
                    <b-button variant="block-option" class="btn-block-option" data-toggle="block-option"
                              data-action="content_toggle"></b-button>
                </div>
            </div>
            <div class="block-content">
                <table class="table table-striped table-borderless table-vcenter">
                    <thead class="bg-primary-dark text-light">
                    <tr>
                        <th style="width: 33%;">Name</th>
                        <th class="d-none d-sm-table-cell">email</th>
                        <th class="d-none d-sm-table-cell">type</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(user,key) in this.users" :key="key">
                        <td>
                            <span>{{user.name}}</span>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span>{{user.email}}</span>
                        </td>
                        <td>
                            <span v-if="user.type == 'location_manager'">Locatie manager</span>
                            <span v-else-if="user.type == 'owner'">BEZORGFIETS Medwerker</span>
                            <span v-else>Fietsenmaker</span>
                        </td>
                        <td class="text-right">
                            <b-button variant="light" size="sm" class="btn-light"
                                      @click="openUserRemovalConfirmationModal(user,key)">
                                <i class="fa fa-fw fa-trash text-primary"></i>
                            </b-button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal v-model="userRemovalConfirmationModal">
            <div v-if="tempUser != null">
                <p>Weet je zeker dat je {{this.tempUser.name}} wilt verwijderen? </p>
            </div>
            <template v-slot:modal-footer>
                <b-button size="danger" data-toggle="click-ripple" @click="closeModal">cancel</b-button>
                <b-button size="alt-primary" data-toggle="click-ripple" @click="removeUser">delete</b-button>
            </template>
        </b-modal>
    </div>
</template>

<script>
    export default {
        name: "UserIndex",
        data() {
            return {
                users: [],
                contact: {
                    name: '',
                    lastname: '',
                    email: '',
                    type: 'location_manager'
                },
                options: [
                    {value: 'location_manager', text: 'Location Manager'},
                    {value: 'mechanic', text: 'Mechanic'},
                    {value: 'owner', text: 'BEZORGFIETS Medwerker'},
                ],
                userRemovalConfirmationModal: false,
                tempUser: null
            };
        },
        created() {
            this.getUsers();
        },
        methods: {
            removeUser() {
                let url = 'axios/users/' + this.tempUser.id + '/delete'
                axios.delete(url)
                    .then(response => {
                        this.$toast.success("Gebruiker succesvol verwijderd!");
                        this.getUsers();
                        this.closeModal();
                    });
            },
            closeModal() {
                this.tempUser = null
                this.userRemovalConfirmationModal = false;
            },
            openUserRemovalConfirmationModal(user, key) {
                this.userRemovalConfirmationModal = true;
                this.tempUser = user;
            },
            getUsers() {
                axios.get('axios/users/get')
                    .then(response => {
                        this.users = response.data;
                    });
            },
            submit() {
                axios.post('axios/users/invite', this.contact).then(response => {
                    this.$toast.success("Uitnodiging verstuurd!");
                });
            },
            resetForm() {

            }
        }
    }
</script>

<style scoped>

</style>
