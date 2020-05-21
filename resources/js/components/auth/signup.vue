<template>
    <div>
        <div class="py-3">
            <div class="form-group">
                <label for="name">Voornaam</label>
                <b-form-input type="text" class="form-control form-control-alt form-control-lg" id="name" name="name" placeholder="Voornaam"></b-form-input>
            </div>
            <div class="form-group">
                <label for="addition">Tussenvoegsel</label>
                <b-form-input type="text" class="form-control form-control-alt form-control-lg" id="addition" name="addition" placeholder="Tussenvoegsel"></b-form-input>
            </div>
            <div class="form-group">
                <label for="lastname">Achternaam</label>
                <b-form-input type="text" class="form-control form-control-alt form-control-lg" id="name" name="lastname" placeholder="Achternaam"></b-form-input>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <b-form-input type="email" class="form-control form-control-lg form-control-alt" id="email" name="email" placeholder="E-mail"></b-form-input>
            </div>
            <div class="form-group">
                <label for="phone">Telefoonnummer</label>
                <b-form-input type="text" class="form-control form-control-lg form-control-alt" id="phone" name="email" placeholder="Telefoonnummer"></b-form-input>
            </div>
            <div class="form-group">
                <label :for="password">Wachtwoord</label>
                <b-form-input type="password" class="form-control form-control-lg form-control-alt" :id="password" name="password" placeholder="Password"></b-form-input>
            </div>
            <div class="form-group">
                <label for="password-confirm">Herhaal wachtwoord</label>
                <b-form-input type="password" class="form-control form-control-lg form-control-alt" id="password-confirm" name="password" placeholder="Password"></b-form-input>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Registreer
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "signup",
        props:[
            'invite'
        ],
        data(){
            return{
                user:{
                    name:'',
                    addition:'',
                    lastname:'',
                    phone:'',
                    email:'',
                    password:'',
                }
            };
        },
        created() {

        },
        methods:{
            signUp(){
                axios.post(url,this.user)
                .then( response =>{

                });
            }
        }
    }
</script>

<style scoped>

</style>
