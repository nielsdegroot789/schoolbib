<template>
  <div class="setup section">This is page for managing the actual users</div>
</template>

<script>
export default {
  data() {
    return {};
  },
  computed: {},
  created() {},
  methods: {},
};
</script>

<style>
.titleColumn {
  display: grid;
  grid-template-columns: repeat(7, calc(90% / 7));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
  font-weight: bold;
}
.usersContainer {
  display: grid;
  grid-template-columns: repeat(7, calc(90% / 7));
  justify-items: center;
  align-items: center;
  margin: 5px 0;
}
</style>
