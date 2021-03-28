<template>
<div class="container mt-5">
<div class="card">
  <div class="card-header">
    FETCH RESULTS
  </div>
<div class="card-body">
<div class="form-group">
  <input type="text" class="form form-control form-control-lg" placeholder="Enter roll numbers" 
  name="rollnumbers" v-model="roll_numbers"/>
  <div v-if="error" class="sep"></div><div class="text-danger px-2" 
  v-if="error">Please Enter roll numbers seperated by a comma<div class="sep"></div></div>
  </div>
  <input type="submit" class="btn btn-block btn-success" value="submit" @click="validate"/>
  </div>
  </div>
  </div>
  <div class="container d-flex justify-content-center">
  <img src="../assets/Spinner.svg" class="mx-auto" v-if="loading"/>
  </div>
  <div class="container mt-5">
  <table v-if="show" class="table table-dark table-bordered">
    <caption>List of roll numbers and respective results</caption>
    <tr class="bg-dark text-white">
      <th>Roll No</th>
      <th>Result</th>
    </tr>
    <tr v-for="data in result" :key="data.key" class="bg-primary">
      <td>{{data.rollnumber}}</td>
      <td>{{data.status}}</td>
    </tr>
  </table>
  </div>
</template>
<script>
import axios from 'axios'
export default{
  data(){
    return{
      roll_numbers:'',
      loading:false,
      result:[],
      show:false,
      error:false
    }
  },
  methods:{
    validate(){
      this.show=false
      var regex=/^\d+([,]\d+)*$/
      if(this.roll_numbers.match(regex)){
      this.loading=true
      axios.post("http://localhost/roll_number_problem/src/components/validate.php",{data:this.roll_numbers})
      .then(
        res=>{
         this.result=res.data
          this.show=true
          this.loading=false
        }
      )
      }
      else{
        this.error=true
      }
    }
  }
}
</script>
<style scoped>
.sep{
  height:5px
}
</style>