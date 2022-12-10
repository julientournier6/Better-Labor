<?php
function fetch_data($conn, $tableName, $columns){
 if(empty($conn)){
  $msg= "Erreur de connexion à la base de données";
 }elseif (empty($columns) || !is_array($columns)) {
  $msg="Les noms des colonnes doivent être définis dans un array indexé";
 }elseif(empty($tableName)){
   $msg= "Le nom de la table est vide";
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

?>