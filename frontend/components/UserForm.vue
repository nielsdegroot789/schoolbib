<template>
  <div class="userFormContainer">
    <FormulateForm v-model="currentUserData" class="section" @submit="saveUser">
      <FormulateInput v-if="currentUserData.id" type="hidden" name="id" />
      <FormulateInput
        label="surname"
        type="text"
        name="surname"
        validation="required"
      />
      <FormulateInput
        label="last name"
        type="text"
        name="lastname"
        validation="required"
      />
      <FormulateInput label="email" type="text" name="email" />
      <FormulateInput type="submit" label="Save" />
    </FormulateForm>

    <div v-if="showError" class="notification is-danger">
      <button class="delete" @click="closeError"></button>
      Make sure that the field is filled in correctly!
    </div>
  </div>
</template>

<script>
export default {
  name: 'Userform',
  components: {},
  props: {
    userData: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      userMetaData: Object,
      showError: false,
    };
  },
  computed: {
    currentUserData: {
      get() {
        return this.userData;
      },
      set(newValue) {
        this.userMetaData = newValue;
      },
    },
  },
  methods: {
    saveUser() {
      this.$emit('updateUserData', this.userMetaData);
    },

    closeError() {
      this.showError = false;
    },
  },
};
</script>

<style scoped>
.userFormContainer {
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: 50% 50%;
  position: relative;
}

.box {
  margin-bottom: 0.5rem;
}
</style>
