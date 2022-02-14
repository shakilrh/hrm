<template>
    <div class="register-box">
        <div class="register-logo">
            <a href="/"><b>{{ name }}</b></a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form @submit.prevent="register" @keydown="form.onKeydown($event)">
                    <!-- Alert -->
                    <alert-error :form="form"></alert-error>

                    <div class="input-group mb-3">
                        <input  v-model="form.name" type="text" name="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="input-group mb-3">
                        <input  v-model="form.email" type="email" name="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="input-group mb-3">
                        <input v-model="form.password" type="password" name="password"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                    <div class="input-group mb-3">
                        <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" placeholder="Confirmation Password">
                        <has-error :form="form" field="password_confirmation"></has-error>
                    </div>

                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

               <!-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus"></i> Sign in using Google+
                    </a>
                </div>-->
                <!-- /.social-auth-links -->

                <a href="/login" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
</template>

<script>
export default {
    props:['name'],
    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        }
    },
    mounted() {
        console.log('Register Component mounted.')
    },
    methods: {
        register () {
            this.$Progress.start();
            this.form.busy = true;
            // Submit the form via a POST request
            this.form.post('/register')
                .then(response => {
                    if (this.form.successful) {
                        this.$Progress.finish()
                        location.replace('/admin/dashboard')
                    } else {
                        this.$Progress.fail()
                    }
                })
                .catch(e => {
                    console.log(e)
                    this.$Progress.fail()
                })
        }
    }
}
</script>
