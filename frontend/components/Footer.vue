<template>
  <footer id="footer" class="footer">
    <div>
      <h1 class="subtitle">Contact information</h1>
      <p v-html="contactInformation"></p>
    </div>
    <div>
      <h1 class="subtitle">Opening hours</h1>
      <p v-html="openingHours"></p>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer',
  data() {
    return {
      privacyPolicy: '',
      openingHours: '',
      contactInformation: '',
    };
  },
  created() {
    this.$axios
      .get('http://localhost:8080/getCockpitFooterData')
      .then((response) => {
        this.privacyPolicy = response.data[1].text;
        this.openingHours = response.data[0].text;
        this.contactInformation = response.data[2].text;
      });
  },
};
</script>

<style>
.subtitle {
  color: white;
  text-align: left;
}
</style>
