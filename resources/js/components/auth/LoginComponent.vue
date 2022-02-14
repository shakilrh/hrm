<template>
  <div class="login-slide slide">
    <div class="d-flex height-100-percentage">
      <div class="align-self-center width-100-percentage">
        <h3>Sign In</h3>
        <form @submit.prevent="login" @keydown="form.onKeydown($event)">
          <!-- Alert -->
          <alert-error :form="form"></alert-error>

          <div class="form-group user-name-field">
            <input
              v-model="form.email"
              type="email"
              name="email"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('email') }"
              placeholder="Email"
              :disabled="form.busy"
            >
            <div class="field-icon">
              <i class="ion-person"></i>
            </div>
            <has-error :form="form" field="email"></has-error>
          </div>
          <div class="form-group margin-bottom-30px forgot-password-field">
            <input
              v-model="form.password"
              type="password"
              name="password"
              class="form-control"
              :class="{ 'is-invalid': form.errors.has('password') }"
              placeholder="Password"
              :disabled="form.busy"
            >
            <div class="field-icon">
              <i class="ion-locked"></i>
            </div>
            <has-error :form="form" field="password"></has-error>
          </div>
          <div class="form-group margin-bottom-30px custom-control custom-checkbox">
            <input
              v-model="form.remember"
              type="checkbox"
              class="custom-control-input"
              id="remember"
              :disabled="form.busy"
            >
            <label class="custom-control-label" for="remember">Remember Me</label>
          </div>
          <div class="form-group sign-in-btn">
            <button :disabled="form.busy" type="submit" class="submit">
              <i v-show="form.busy" class="fas fa-spinner fa-spin"></i>
              <span>Sign In</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["name"],
  data() {
    return {
      form: new Form({
        email: "",
        password: "",
        remember: false
      })
    };
  },
  mounted() {
    console.log("Login Component mounted.");
  },
  methods: {
    login() {
      this.$Progress.start();
      this.form.busy = true;
      // Submit the form via a POST request
      this.form
        .post("/login")
        .then(response => {
          if (this.form.successful) {
            this.$Progress.finish();
            location.href = homeUrl + "/dashboard";
          } else {
            this.$Progress.fail();
          }
        })
        .catch(e => {
          console.log(e);
          this.$Progress.fail();
        });
    }
  }
};
</script>
