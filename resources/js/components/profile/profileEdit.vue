<template>
    <div>
        <div class="block block-rounded block-bordered">
            <div class="block-content">
                    <!-- User Profile -->
                    <h2 class="content-heading pt-0">
                        <i class="fa fa-fw fa-user-circle text-muted mr-1"></i>
                        Profiel
                    </h2>
                    <div class="row push">
                        <div class="col-lg-4">
                            <p class="text-muted">
                                Your account’s vital info. Your username will be publicly visible.
                            </p>
                        </div>
                        <div class="col-lg-8 col-xl-5">
                            <div class="form-group">
                                <label for="dm-profile-edit-username">Username</label>
                                <input type="text" class="form-control" id="dm-profile-edit-username" name="dm-profile-edit-username" placeholder="Enter your username.." value="john.doe">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-name">Name</label>
                                <input type="text" class="form-control" id="dm-profile-edit-name" name="dm-profile-edit-name" placeholder="Enter your name.." value="John Doe">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-email">Email Address</label>
                                <input type="email" class="form-control" id="dm-profile-edit-email" name="dm-profile-edit-email" placeholder="Enter your email.." value="john.doe@example.com">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-job-title">Job Title</label>
                                <input type="text" class="form-control" id="dm-profile-edit-job-title" name="dm-profile-edit-job-title" placeholder="Add your job title.." value="Product Manager">
                            </div>
                            <div class="form-group">
                                <label for="dm-profile-edit-company">Company</label>
                                <input type="text" class="form-control" id="dm-profile-edit-company" name="dm-profile-edit-company" value="@ProXdesign" readonly>
                            </div>
                            <div class="form-group">
                                <label>Your Avatar</label>
                                <div class="push">
                                    <img class="img-avatar" src="assets/media/avatars/avatar10.jpg" alt="">
                                </div>
                                <div class="custom-file">
                                    <!-- Populating custom file input label with the selected filename (data-toggle="custom-file-input" is initialized in Helpers.coreBootstrapCustomFileInput()) -->
                                    <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="dm-profile-edit-avatar" name="dm-profile-edit-avatar">
                                    <label class="custom-file-label" for="dm-profile-edit-avatar">Choose a new avatar</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END User Profile -->

                    <!-- Change Password -->
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
                                    <i class="fa fa-check-circle mr-1"></i> Update Profile
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
        name: "profileEdit",
        props:[
            'user'
        ]
    }
</script>

<style scoped>

</style>
