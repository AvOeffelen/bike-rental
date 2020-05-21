<template>
    <div>
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">Bicycles</h3>
            </div>
            <div class="block-content">
                <!--                    <form class="push" action="be_pages_blog_post_manage.html" method="POST">-->
                <!--                        <div class="input-group">-->
                <!--                            <input type="text" class="form-control" placeholder="Search Posts..">-->
                <!--                            <div class="input-group-append">-->
                <!--                                        <span class="input-group-text">-->
                <!--                                            <i class="fa fa-fw fa-search"></i>-->
                <!--                                        </span>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </form>-->
                <!-- Posts Table -->
                <div v-if="this.loading == true" class="text-center">
                    <div class="spinner-grow text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <table class="table table-striped table-borderless table-vcenter" v-else>
                    <thead class="bg-primary-dark text-light">
                        <tr>
                            <th style="width: 33%;">Frame number</th>
                            <th class="d-none d-sm-table-cell">available</th>
                            <th class="d-none d-sm-table-cell">in repair</th>
                            <th style="width: 200px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <b-form-input v-model="new_bicycle.framenumber" placeholder="12345DF459" type="text" autocomplete="false"
                                              class="form-control form-control"></b-form-input>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <b-form-select v-model="new_bicycle.available"
                                               class="custom-select form-control form-control"
                                               :options="options"></b-form-select>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <b-form-select v-model="new_bicycle.available"
                                               class="custom-select form-control form-control"
                                               :options="options"></b-form-select>
                            </td>
                            <td class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" @click="submitForm(bicycle)">
                                    <i class="fa fa-fw fa-check text-primary"></i>
                                </b-button>
                            </td>
                        </tr>
                        <tr v-for="(bicycle,key) in this.bicycles.data" :key="key">
                            <td>
                                <div v-if="isEditing.currently == true && isEditing.key == key">
                                    <b-form-input v-model="bicycle.framenumber" placeholder="12345DF459" type="text"
                                                  class="form-control form-control"></b-form-input>
                                </div>
                                <div v-else>
                                    <span>{{bicycle.framenumber}}</span>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <div v-if="isEditing.currently == true && isEditing.key == key">
                                    <b-form-select v-model="bicycle.available"
                                                   class="custom-select form-control form-control"
                                                   :options="options"></b-form-select>
                                </div>
                                <div v-else>
                                    <span v-if="bicycle.available == 0">Not available</span>
                                    <span v-else>Available</span>
                                </div>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <div v-if="isEditing.currently == true && isEditing.key == key">
                                    <b-form-select v-model="bicycle.in_repair"
                                                   class="custom-select form-control form-control"
                                                   :options="options"></b-form-select>
                                </div>
                                <div v-else>
                                    <span v-if="bicycle.in_repair == 0">Not in repair</span>
                                    <span v-else>In repair</span>
                                </div>
                            </td>
                            <td class="text-right">
                                <b-button variant="light" size="sm" class="btn-light" @click="updateBicycle(bicycle,key)"
                                          v-if="isEditing.currently == true && isEditing.key == key">
                                    <i class="fa fa-fw fa-check text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light" @click="initEditBicycle(bicycle,key)"
                                          v-else>
                                    <i class="fa fa-fw fa-pencil-alt text-primary"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light" @click="cancelEditing(bicycle,key)"
                                          v-if="isEditing.currently == true && isEditing.key == key">
                                    <i class="fa fa-fw fa-times text-danger"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light" @click="removeBicycle(bicycle,key)"
                                          v-else>
                                    <i class="fa fa-fw fa-trash text-danger"></i>
                                </b-button>
                                <b-button variant="light" size="sm" class="btn-light">
                                    <i class="fa fa-fw fa-search text-primary"></i>
                                </b-button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Posts Table -->

                <!-- Psts Pagincation -->
                <div v-if="this.bicycles == null"></div>
                <pagination v-else
                            class="pagination-margin"
                            size="small"
                            :data="bicycles"
                            @pagination-change-page="getBicycles">
                </pagination>
                <!-- END Posts Pagincation -->
            </div>
        </div>
    </div>
</template>

<script>
    function initialState() {
        return {
            new_bicycle: {
                framenumber: '',
                available: 1,
                in_repair: 0
            },
        }
    }
    export default {
        name: "bicycleIndex",
        data() {
            return {
                new_bicycle: {
                    framenumber: '',
                    available: 1,
                    in_repair: 0
                },
                options: [
                    {value: 1, text: "yes"},
                    {value: 0, text: "no"}
                ],
                bicycles: {},
                loading: true,
                isEditing:
                    {
                        currently: false,
                        key: null
                    },
                errors: []
            };
        },
        created() {
            setTimeout(() => {
                this.loading = false;
                this.getBicycles();
                console.log(this.bicycles);
            }, 1000);
        },
        mounted() {
        },
        methods: {
            submitForm() {
                let url = variables.post_bicycles;
                console.log(url);
                axios.post(url, this.new_bicycle)
                    .then(response => {
                        this.bicycles.data.push(response.data);
                        console.log("rsss",response.data);
                        Object.assign(this.new_bicycle,initialState());
                        console.log("bike",this.new_bicycle);
                        console.log("initstate",initialState());
                    });
            },
            getBicycles(page = 1) {
                let url = variables.paginate_bicycles;
                axios.get(url + '?page=' + page)
                    .then(response => {
                        console.log(response);
                        this.bicycles = response.data;
                    });
            },
            initEditBicycle(bicycle, key) {
                this.isEditing.currently = true;
                this.isEditing.key = key;

                this._beforeEditingCache = bicycle;
                this._beforeEditingCache = Object.assign({}, bicycle);
            },
            cancelEditing(bicycle, key) {

                Object.assign(this.bicycles.data[key], this._beforeEditingCache);
                this._beforeEditingCache = null;

                this.isEditing.currently = false;
                this.isEditing.key = null;
            },
            updateBicycle(bicycle, key) {
                let url = variables.update_bicycle.format(bicycle.id);

                axios.put(url, bicycle).then(response => {

                    for (let b in this.bicycles.data) {
                        if (b === key) {
                            this.bicycles.data[b] = bicycle;
                        }
                    }
                    this._beforeEditingCache = null;
                    this.isEditing.currently = false;
                    this.isEditing.key = null;
                });

            },
            removeBicycle(bicycle, key) {
                let url = variables.remove_bicycle.format(bicycle.id);
                axios.delete(url).then(response => {
                    this.bicycles.data.splice(key, 1);
                    if (this.bicycles.data.length == 0) {
                        this.getBicycles();
                    }
                });
            },
        }
    }
</script>

<style scoped>

</style>
