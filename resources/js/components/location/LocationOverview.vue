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
<!--                        TODO:: this has no actions yet, consider making some..????-->
                        <th style="width: 33%;">Frame nummer</th>
                        <th style="width: 33%;">leased</th>
                        <th style="width: 200px;" class="text-center">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(bicycle,index) in location.bicycle">
                            <td>{{bicycle.framenumber}}</td>
                            <td>
                                <span v-if="bicycle.lease_start && bicycle.lease_end !== null">
                                    {{bicycle.lease_start}} - {{ bicycle.lease_end}}
                                </span>
                                <span v-else>
                                    -
                                </span>
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
        name: "locationOverview",
        props:[
            'location'
        ],
        data(){
          return{

          }  ;
        },
        created() {

        },
        methods:{

        }
    }
</script>

<style scoped>

</style>
