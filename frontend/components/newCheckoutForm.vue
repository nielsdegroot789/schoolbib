<template>
  <div class="checkoutForm">
    <FormulateInput type="text" label="userName" placeholder="Student name" />
    <FormulateInput type="text" label="book" placeholder="Book name" />
    <FormulateInput
      type="date"
      label="checkoutDateTime"
      placeholder="checkoutDateTime"
    />
    <FormulateInput
      type="date"
      label="maxAllowedDate"
      placeholder="maxAllowedDate"
    />
    <button>add new</button>
  </div>
</template>

<script>
export default {
  name: 'NewCheckoutForm',
  props: {
    checkoutData: {
      type: Object,
      default() {
        return {};
      },
    },
  },
};
</script>

<style scoped></style>
