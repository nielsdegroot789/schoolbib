<template>
  <div>
    <newCheckoutForm :checkout-data="checkoutData" />
  </div>
</template>

<script>
import newCheckoutForm from '~/components/newCheckoutForm.vue';
export default {
  name: 'New',
  components: { newCheckoutForm },
  data() {
    return {
      ready: false,
      checkoutData: {},
    };
  },
};
</script>

<style scoped></style>
