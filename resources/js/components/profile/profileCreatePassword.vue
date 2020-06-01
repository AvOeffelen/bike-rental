<template>
    <div>
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                <div v-if="this.user.pw_changed == 0">
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-asterisk text-muted mr-1"></i>
                        Maak wachtwoord aan
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Maak een wachtwoord aan voordat u verder kunt.
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password-new">Wachtwoord</label>
                                    <input type="password" class="form-control" id="password-new" name="dm-profile-edit-password-new">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="password-new-confirm">Herhaal wachtwoord</label>
                                    <input type="password" class="form-control" id="password-new-confirm" name="dm-profile-edit-password-new-confirm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-asterisk text-muted mr-1"></i>
                        Verander wachtwoord
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">

                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="form-group">
                                <label for="dm-profile-edit-password">Current Password</label>
                                <input type="password" class="form-control" id="dm-profile-edit-password" name="dm-profile-edit-password">
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="dm-profile-edit-password-new">New Password</label>
                                    <input type="password" class="form-control" id="dm-profile-edit-password-new" name="dm-profile-edit-password-new">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="dm-profile-edit-password-new-confirm">Confirm New Password</label>
                                    <input type="password" class="form-control" id="dm-profile-edit-password-new-confirm" name="dm-profile-edit-password-new-confirm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Change Password -->

                <!-- Submit -->
                <div class="row push">
                    <div class="col-lg-8 col-xl-5 offset-lg-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-check-circle mr-1"></i> Maak wachtwoord aan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "profileCreatePassword",
        props:[
            'user'
        ]
    }
</script>

<style scoped>

</style>
