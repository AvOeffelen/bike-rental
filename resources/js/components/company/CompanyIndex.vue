<template>
    <div>
        <company-create></company-create>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Bedrijven</h3>
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
                        <th class="d-none d-sm-table-cell">aantal vestigigingen</th>
                        <th class="d-none d-sm-table-cell">contact persoon</th>
                        <th style="width: 200px;" class="text-center">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
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
                loading:true
            };
        },
        created() {
            setTimeout( ()=>{
                this.loading = false;
            },5000)
        },
        methods:{

        }
    }
</script>

<style scoped>

</style>
