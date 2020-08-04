<template>
  <div>
    <section class="section">
      <div class="container">
        <div class="columns">
          <div class="column is-4 is-offset-4">
            <h2 class="title has-text-centered">Register!</h2>

            <!-- <Notification v-if="error" :message="error" /> -->

            <form method="post">
              <div class="field">
                <label class="label">Username</label>
                <div class="control">
                  <input
                    v-model="register.username"
                    type="text"
                    class="input"
                    label="Username"
                    value="benno.demey@outlook.com"
                    required
                  />
                </div>
              </div>
              <div class="field">
                <label class="label">Email</label>
                <div class="control">
                  <input
                    v-model="register.email"
                    type="email"
                    class="input"
                    label="Email"
                    value="benno.demey@outlook.com"
                    required
                  />
                </div>
              </div>
              <div class="field">
                <label class="label">Password</label>
                <div class="control">
                  <input
                    v-model="register.password"
                    type="password"
                    class="input"
                    label="Password"
                    required
                  />
                </div>
              </div>
              <div class="control">
                <button type="submit" class="button is-dark is-fullwidth">
                  Register
                </button>
              </div>
            </form>

            <div class="has-text-centered" style="margin-top: 20px;">
              Already got an account? <nuxt-link to="/login">Login</nuxt-link>
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
      register: {
        username: '',
        email: '',
        password: '',
      },
    };
  },
};
</script>
