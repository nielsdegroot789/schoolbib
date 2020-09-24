<template>
  <div>
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-4 is-offset-4">
            <h2 class="title has-text-centered">Welcome back!</h2>

            <!-- <Notification v-if="error" :message="error" /> -->

            <form>
              <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input
                    v-model="email"
                    type="text"
                    class="input"
                    name="email"
                  />
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
            </form>
            <div class="has-text-centered" style="margin-top: 20px">
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

<style lang="scss"></style>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
    };
  },
  methods: {
    login(data) {
      this.$store.dispatch('login', data);
    },
  },
};
</script>
