<template>
  <div>
    <h1>this is the list of books that you vhevked out and reserved</h1>
    <h2>My reserved Books</h2>
    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>id_user</th>
          <th>name_user</th>
          <th>id_book</th>
          <th>name_book</th>
          <th>reservation date</th>
          <th>Accept</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in reservations" :key="index">
          <td>{{ item.usersId }}</td>
          <td>{{ item.usersName }}</td>
          <td>{{ item.booksId }}</td>
          <td>{{ item.booksName }}</td>
          <td>{{ item.reservationDateTime }}</td>
          <td class="checkoutBtn" @click="saveCheckout(item)">delete</td>
        </tr>
      </tbody>
    </table>
    <h2>Checkouts</h2>

    <table class="table table is-bordered is-hoverable is-fullwidth">
      <thead>
        <tr>
          <th>userName</th>
          <th>book</th>
          <th>checkoutDateTime</th>
          <th>maxAllowedDate</th>
          <th>fine</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in checkouts" :key="index">
          <td>{{ item.usersName }}</td>
          <td>{{ item.booksName }}</td>
          <td>{{ item.checkoutDateTime }}</td>
          <td>{{ item.maxAllowedDate }}</td>
          <td>{{ item.fine }}</td>
          <td
            class="checkoutBtn"
            @click="returnCheckouts(item, index) in checkouts"
          >
            delete
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {};
</script>

<style>
h1 {
  text-align: center;
}
</style>
