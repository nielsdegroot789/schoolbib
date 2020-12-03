<template>
  <FormulateForm v-model="values" :values="checkoutData" @submit="saveCheckout">
    <h2>Form for a user who wants to checkout a book.</h2>
    <FormulateInput
      v-model="usersId"
      type="number"
      label="usersId"
      placeholder="usersId: 1,2,.."
    />
    <FormulateInput
      v-model="booksId"
      type="number"
      label="booksId"
      placeholder="BookId: 1,2,.."
    />
    <FormulateInput v-model="checkoutDateTime" type="date" label="Date" />
    <FormulateInput v-model="maxAllowedDate" type="date" label="max - Date" />

    <FormulateInput
      v-model="usersName"
      type="text"
      label="Student name"
      placeholder="Student name"
    />
    <FormulateInput
      v-model="usersName"
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
      this.axios
        .post('http://localhost:8080/getCheckouts', this.checkoutData)
        .then((result) => {
          console.warn(result);
        });
    },
  },
};
</script>

<style></style>
