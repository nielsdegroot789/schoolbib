<template>
  <section class="section">
    <div class="container">
      <h2 class="title">My Profile</h2>
      <div class="content">
        <p>
          <strong>Username:</strong>
          {{ loggedInUser.username }}
        </p>
        <p>
          <strong>Email:</strong>
          {{ loggedInUser.email }}
        </p>
        <Title>Hello Yall readers whom are logged in </Title>
      </div>
    </div>
  </section>
</template>

<script>
export default {};
</script>
