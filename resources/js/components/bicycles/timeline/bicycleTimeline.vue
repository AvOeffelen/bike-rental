<template>
    <div>
        <b-row>
            <b-col>
                <div class="block">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Fiets tijdlijn</h3>
                    </div>
                    <div class="block-content">
                        <b-row>
                            <b-col>
                                <div class="text-center">
                                    <label>Selecteer een fiets</label>
                                    <multiselect v-model="selectedBicycle"
                                                 class="select_bike"
                                                 :options="bicycles"
                                                 :preselect-first="true"
                                                 placeholder="Select bicycle"
                                                 label="framenumber"
                                                 track-by="framenumber">
                                    </multiselect>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row class="pt-5">
                            <b-col>
                                <div class="text-center" v-if="selectedBicycle == null">
                                    <p>Selecteer een fiets om de tijdlijn te bekijken</p>
                                </div>
                                <ul class="timeline timeline-centered timeline-alt" v-else>
                                    <li class="timeline-event" v-for="(event,key) in this.selectedBicycle.bicycle_history">
                                        <div class="timeline-event-icon bg-xbr-dark">
                                        </div>
                                        <div class="timeline-event-block block block-rounded block-fx-pop visible"
                                             data-toggle="appear">
                                            <div class="block-header block-header-default">
                                                <h3 class="block-title">{{event.title}}</h3>
                                                <div class="block-options">
                                                    <div
                                                        class="timeline-event-time block-options-item font-size-sm font-w600">
                                                        {{event.created_at}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block-content">
                                                <div class="flex-fill mr-3 pt-2 pb-3">
                                                    <p class="mb-0">
                                                        {{event.description}}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    export default {
        name: "bicycle",
        components: {},
        data() {
            return {
                bicycles: [],
                selectedBicycle: null,
            };
        },
        created() {
            this.getAllBicycles();
        },
        methods: {
            getAllBicycles() {
                let url = '/axios/bicycle/get';
                axios.get(url)
                    .then(response => {
                        this.bicycles = response.data;
                    })
            },
        }
    }
</script>

<style lang="scss" scoped>

    $theme-xbr-primary: #f47e57 !default;
    $theme-xbr-light: lighten($theme-xbr-primary, 10%) !default;
    $theme-xbr-lighter: lighten($theme-xbr-primary, 30%) !default;
    $theme-xbr-dark: darken($theme-xbr-primary, 12%) !default;
    $theme-xbr-darker: darken($theme-xbr-primary, 35%) !default;

    .bg-xbr-darker {
        background: $theme-xbr-darker;
    }

    .bg-xbr-dark {
        background: $theme-xbr-dark;
    }
</style>
