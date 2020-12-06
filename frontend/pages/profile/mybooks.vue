<template>
  <div>
    <h1>this is the list of books that you vhevked out and reserved</h1>
    <h2>My reserved Books</h2>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>name_book</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in reservations" :key="index">
          <td>{{ item.booksName }}</td>
          <td>decline</td>
          <td class="checkoutBtn" @click="saveCheckout(item)">delete</td>
        </tr>
      </tbody>
    </table>
    <h2>Checkouts</h2>

    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>booksName</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
          <th>DELETE</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in checkouts" :key="index">
          <td>{{ item.booksName }}</td>
          <td>{{ item.maxAllowedDate }}</td>
          <td>{{ item.fine }}</td>
          <td
            class="checkoutBtn"
            @click="returnCheckouts(item, index) in checkouts"
          ></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {};
</script>

<style></style>
