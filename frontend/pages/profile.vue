<template>
  <div id="profile-page-container">
    <div class="profile-navigation-container"></div>
    <div class="main-profile-container">
      <profileInformation />
    </div>
  </div>
</template>

<script>
import profileInformation from '../components/profilePageInformation';
export default {
  components: { profileInformation },
};
</script>
