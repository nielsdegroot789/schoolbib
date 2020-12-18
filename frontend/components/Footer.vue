<template>
  <div>
    <footer id="footer" class="footer">
      <div>
        <h1 class="subtitle">Contact information</h1>
        <p v-html="contactInformation"></p>
      </div>
      <div class="opening-hours--footer">
        <h1 class="subtitle">Opening hours</h1>
        <p v-html="openingHours"></p>
      </div>
      <div class="privacy-policy--footer">
        <button class="button" @click="setModalVisibility(true)">
          View our privacy policy
        </button>
      </div>
    </footer>
    <div v-if="showModal" class="modal is-active">
      <div class="modal-background" @click="setModalVisibility(false)"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Privacy Policy</p>
          <button
            class="delete"
            aria-label="close"
            @click="setModalVisibility(false)"
          ></button>
        </header>
        <section class="modal-card-body">
          <!-- Content ... -->
          <p v-html="privacyPolicy"></p>
        </section>
        <footer class="modal-card-foot">
          <button class="button" @click="setModalVisibility(false)">
            Close
          </button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Footer',
  data() {
    return {
      privacyPolicy: '',
      openingHours: '',
      contactInformation: '',
      showModal: false,
    };
  },
  created() {
    this.$axios.get('getCockpitFooterData').then((response) => {
      this.privacyPolicy = response.data[1].text;
      this.openingHours = response.data[0].text;
      this.contactInformation = response.data[2].text;
    });
  },
  methods: {
    setModalVisibility(bool) {
      this.showModal = bool;
    },
  },
};
</script>

<style>
.subtitle {
  color: white;
  text-align: left;
}
@media only screen and (max-width: 600px) {
  .manageOverlay {
    display: none;
  }
  .books {
    display: none;
  }
}
</style>
