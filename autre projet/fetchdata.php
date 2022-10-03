<?php
function fetch_data($conn, $tableName, $columns){
 if(empty($conn)){
  $msg= "Database connection error";
 }elseif (empty($columns) || !is_array($columns)) {
  $msg="columns Name must be defined in an indexed array";
 }elseif(empty($tableName)){
   $msg= "Table Name is empty";
}else{
$columnName = implode(", ", $columns);
$query = "SELECT ".$columnName." FROM $tableName"." ORDER BY id DESC";
$result = $conn->query($query);
if($result== true){ 
 if ($result->num_rows > 0) {
    $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $msg= $row;
 } else {
    $msg= "No Data Found"; 
 }
}else{
  $msg= mysqli_error($conn);
}
}
return $msg;
}

function subscribers($conn){
    $query = "SELECT subscribed FROM user WHERE subscribed = 1";
    $result = $conn->query($query);
    if ($result == true) return $result->num_rows;
}
?>