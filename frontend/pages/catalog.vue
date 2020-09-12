<template>
  <div id='myapp'>

    <input type='text' v-model='bookName' placeholder="Enter a name of a book">

    <input type='button' @click='allBooks()' value='Select all books'>
    <br><br>

    <table>
        <tr>
        <th>title</th>
        <th>Rating</th>
        <th>Email</th>
        </tr>

        <tr v-for='books in MetaBook'>
        <td>{{ MetaBook.title }}</td>
        <td>{{ MetaBook.name }}</td>
        <td>{{ MetaBook.email }}</td>
        </tr>
    </table>
 
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>template>
