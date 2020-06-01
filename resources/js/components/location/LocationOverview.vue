<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{location.name}}</h3>
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
                        <th style="width: 33%;">leased</th>
                        <th style="width: 200px;" class="text-center">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(bicycle,index) in location.bicycle" :key="index">
                        <td>{{bicycle.framenumber}}</td>
                        <td>
                                <span v-if="bicycle.lease_start && bicycle.lease_end !== null">
                                    {{bicycle.lease_start}} - {{ bicycle.lease_end}}
                                </span>
                            <span v-else>
                                    -
                                </span>
                        </td>
                        <td>
                            <div class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" data-toggle="tooltip" data-placement="top" title="Stop huur periode"
                                          @click="initTransferBicycleBackModal(bicycle,index)">
                                    <i class="fa fa-fw fa-arrow-left text-primary"></i>
                                </b-button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal v-model="cancelLeaseModal" size="lg" title="Lease cancelen">
            <p>Wil je deze fiets terug halen naar BEZORGFIETS? Je maakt de fiets dan weer toegankelijk om te verhuren
                aan andere locaties.</p>
            <template v-slot:modal-footer>
                <b-button size="sm" variant="danger" @click="closeCancelLeaseModal">Cancel</b-button>
                <b-button variant="alt-primary" size="sm" @click="transferBicycleBack()">Transfer</b-button>
            </template>
        </b-modal>
    </div>
</template>
<script>
    function initialBikeTransferState() {
        return {
            bicycle: null,
            location: null,
            start: null,
            end: null
        };
    }

    export default {
        name: "locationOverview",
        props: [
            'location'
        ],
        data() {
            return {
                cancelLeaseModal: false,
                bicycleTransferInformation: {
                    bicycle: null,
                    location: null,
                    start: null,
                    end: null
                },
            };
        },
        created() {

        },
        methods: {
            closeCancelLeaseModal() {
                this.cancelLeaseModal = false;
                Object.assign(this.bicycleTransferInformation, initialBikeTransferState());
            },
            initTransferBicycleBackModal(bicycle) {
                this.cancelLeaseModal = true;
                this.bicycleTransferInformation = bicycle;
            },
            transferBicycleBack() {
                axios.post('/axios/bicycle/transfer-back', this.bicycleTransferInformation)
                    .then(response => {
                        let bike = response.data;
                        for (let b in this.location.bicycle) {
                            if (this.location.bicycle[b].id == bike.id) {
                                this.location.bicycle.splice(b,1);
                            }
                        }
                        Object.assign(this.bicycleTransferInformation, initialBikeTransferState());
                        this.cancelLeaseModal = false;
                    });
            },
        }
    }
</script>

<style scoped>

</style>
