# Terribly Tiny Tales
 Fetch results is an application which allows clients to enter specific roll numbers seperated by a comma and it will give result of each and every roll number entered by client in tabular format. 
## Application illustration
Firstly, client is prompted to enter valid roll numbers which will be acquired by using input tags respectively for both user input and submit button. This template is styled using **bootstrap's** card and form utility-first classes.
```html
<input type="text" class="form form-control form-control-lg" placeholder="Enter roll numbers" name="rollnumbers" v-model="roll_numbers"/>

<input type="submit" class="btn btn-block btn-success" value="submit" @click="validate"/>
```
Once the client clicks on submit after providing input, it will check whether provided user input is valid according to a regular expression. If it is valid then **axios** will send HTTPS request to backend in which user input will be sent as an arguement to get results for the given roll numbers otherwise it will give an error message to provide valid input to the client.
```html
<div class="text-danger px-2" 
v-if="error">Please Enter roll numbers seperated by a comma<div class="sep"></div></div>
</div>
```
```js
axios.post("http://localhost/roll_number_problem/src/components/validate.php",{data:this.roll_numbers})
``` 
If **axios** sent request is successfully received by backend then application will show a spinner indicating the requested data is being processed and once the request succesfully fetches the required data it will represent the data in JSON format which will be eventually represented in tabular format in frontend.
```html
<div class="container d-flex justify-content-center">
<img src="../assets/spinner.svg" class="mx-auto" v-if="loading"/>
</div>
```
In the backend, the received roll numbers will be pushed into an array one by one which basically are exploded with comma and then fetches data from external API for individual roll numbers.
```php
$recieved_data=json_decode(file_get_contents("php://input"),true);
$array_value=explode(",", $recieved_data['data']);

foreach($array_value as $item){
    $response=stream_get_contents(fopen("https://terriblytinytales.com/testapi?rollnumber=$item","r"));
    array_push($result,$response);
}
```
> Here, **explode** function will seperate client input by using comma as a delimitter and **stream_get_contents** will fetch data from the provided url by using **fopen** to open the url.

Then, the acquired result and the user input combined will be pushed into an object one by one and finally the array of objects will be represented in JSON format so that the front end can access it to represent the data.
```php
foreach($result as $key=>$value){
  $myobj=new \stdClass();
  $myobj->rollnumber=$array_value[$key];
  $myobj->status=$result[$key];
  unset($result[$key]);
  $result[]=$myobj;
}

echo json_encode($result);
```
If the backend successfully represents the data then the result data or promise of axios request will be pushed into an array in frontend which eventually will be fetched while we represent data in tabular format.
```js
result:[]

this.result=res.data
```
```html
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
```
> Here **v-for** represents the attribute for the no.of roll numbers entered by client and their respective results which will be found in Vue's data.
## Use cases
 ### 1. Valid User Input

 ![valid-user-input](src\assets\terribly1.PNG)
 ### 2. Invalid User Input
 ![invalid-user-input](src\assets\terribly2.PNG)
 ### 3. Successfull retrieval of data
 ![succesfull-retrieval](src\assets\terribly3.PNG)
## Demo
![Demo](src\assets\Demo.gif)
## Technology Stack
- [Vite](https://vitejs.dev/)
- [Vue js](https://v3.vuejs.org/)
-  [PHP](https://www.php.net/)
- [Bootstrap](https://getbootstrap.com/)
- [Axios](https://github.com/axios/axios)

