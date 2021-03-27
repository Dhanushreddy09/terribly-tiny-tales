<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
$recieved_data=json_decode(file_get_contents("php://input"),true);
$array_value=explode(",", $recieved_data['data']);
$result=[];
foreach($array_value as $item){
    $response=stream_get_contents(fopen("https://terriblytinytales.com/testapi?rollnumber=$item","r"));
    array_push($result,$response);
}
foreach($result as $key=>$value){
  $myobj=new \stdClass();
  $myobj->rollnumber=$array_value[$key];
  $myobj->status=$result[$key];
  unset($result[$key]);
  $result[]=$myobj;
}
echo json_encode($result);
?>