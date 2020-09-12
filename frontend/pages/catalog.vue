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
 data: {
    users: "",
    userid: 0
  },
  methods: {
    allRecords: function(){

      axios.get('ajaxfile.php')
      .then(function (response) {
         app.users = response.data;
      })
      .catch(function (error) {
         console.log(error);
      });
    },
    recordByID: function(){
      if(this.userid > 0){
 
        axios.get('ajaxfile.php', {
           params: {
             userid: this.userid
           }
        })
        .then(function (response) {
           app.users = response.data;
        })
        .catch(function (error) {
           console.log(error);
        });
      }
    }
  }
}
</script>

<style>

</style>template>
