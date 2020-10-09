<template>
  <div>
    <emailModal />
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-6 is-offset-4">
            <h2 class="title has-text-centered">Welcome back!</h2>

            <div class="field">
              <label class="label">Name</label>
              <div class="control">
                <input v-model="email" type="text" class="input" name="email" />
              </div>
            </div>
            <div class="field">
              <label class="label">Password</label>
              <div class="control">
                <input
                  v-model="password"
                  type="password"
                  class="input"
                  name="password"
                />
              </div>
            </div>
            <div class="control">
              <button
                class="button is-dark is-fullwidth"
                @click="login({ email: email, password: password })"
              >
                Log In
              </button>
            </div>
            <div class="has-text-centered" style="margin-top: 20px">
              <div v-if="showError" class="errorMessage">
                Error: This combination is not found.
              </div>
              <div>
                <p class="reset" @click="openEmailModal">
                  Forgot your password?
                </p>
              </div>
              <p>
                Don't have an account?
                <nuxt-link to="/register">Register</nuxt-link>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<style lang="scss">
.errorMessage {
  color: red;
}
.reset {
  text-decoration: none;
  color: #4a4a4a;
  line-height: 2;
}
.reset:hover {
  color: #3273dc;
  cursor: pointer;
}
.hide {
  display: none;
}
</style>

<script>
import emailModal from '../components/sendEmailModal';
export default {
  /* middleware({ store, redirect }) {
    // If the user is not authenticated
    if (store.state.JWT) {
      return redirect('/');
    }
  },
  */
  // middleware: 'auth',
  components: {
    emailModal,
  },

  data() {
    return {
      email: '',
      password: '',
      setModal: false,
    };
  },
  computed: {
    showError() {
      return this.$store.state.showLoginError;
    },
  },
  methods: {
    login(data) {
      this.$store.dispatch('login', data);
    },
    openEmailModal() {
      this.$store.dispatch('openEmailModal');
    },
  },
};
</script>
