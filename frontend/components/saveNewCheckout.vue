<template>
  <FormulateForm v-model="values" :values="checkoutData" @submit="saveCheckout">
    <h2>Form for a user who wants to checkout a book.</h2>
    <FormulateInput
      v-model="checkoutData.usersId"
      type="number"
      label="usersId"
      placeholder="usersId: 1,2,.."
    />
    <FormulateInput
      v-model="checkoutData.booksId"
      type="number"
      label="booksId"
      placeholder="BookId: 1,2,.."
    />
    <FormulateInput
      v-model="checkoutData.checkoutDateTime"
      type="text"
      label="text"
    />
    <FormulateInput
      v-model="checkoutData.maxAllowedDate"
      type="text"
      label="max - text"
    />

    <FormulateInput
      v-model="checkoutData.usersName"
      type="text"
      label="Student name"
      placeholder="Student name"
    />
    <FormulateInput
      v-model="checkoutData.booksName"
      type="text"
      label="Student name"
      placeholder="Student name"
    />
    <FormulateInput type="submit" label="Save" />
  </FormulateForm>
</template>

<script>
export default {
  name: 'SaveNewCheckout',
  data() {
    return {
      checkoutData: {
        usersId: null,
        booksId: null,
        checkoutDateTime: null,
        maxAllowedDate: null,
        usersName: null,
        booksName: null,
      },
    };
  },
  methods: {
    saveCheckout(data) {
      const headers = {
        Auth: localStorage.getItem('JWT'),
      };
      this.axios
        .post('getCheckouts', this.checkoutData, { headers })
        .then((result) => {
          console.warn(result);
        });
    },
  },
};
</script>

<style></style>
