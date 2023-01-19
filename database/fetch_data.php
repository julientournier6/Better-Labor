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
   if (isset($_GET['text']) && $tableName == "utilisateur") {
      $text = $_GET['text'];
      $text = "%" . $text . "%";
      $agemin = $_GET['agemin'];
      $agemax = $_GET['agemax'];
      
      $datemin = new DateTime();
      $datemax = new DateTime();
      $dateminstr = $datemin->modify('-' . strval($agemax) . ' year')->format('Y-m-d');
      $datemaxstr = $datemax->modify('-' . strval($agemin) . ' year')->format('Y-m-d');
      $query = "SELECT $columnName FROM $tableName
      WHERE (CONCAT(prenom, ' ', nom) LIKE ? OR CONCAT(nom, ' ', prenom) LIKE ? OR email LIKE ? OR telephone LIKE ?)
      AND date_naissance >= ? AND date_naissance <= ?";
      $genre = $_GET['genre'];
      if ($genre == 1 || $genre == 2) {
         
         $query = $query . " AND genre = '$genre'";
      }
      if ($_SESSION["role"] == "chef") {
         $id_chef = $_SESSION['ID'];
         $query = $query . " AND id_chef = ?";
         $query = $query . " ORDER BY id DESC";
         $stmt = $conn->prepare($query);
         $stmt->bind_param('sssssss', $text, $text, $text, $text, $dateminstr, $datemaxstr, $id_chef);
      }
      else {
         $query = $query . " ORDER BY id DESC";
         $stmt = $conn->prepare($query);
         $stmt->bind_param('ssssss', $text, $text, $text, $text, $dateminstr, $datemaxstr);
      }
   }
   else if (isset($_GET['text-chef']) && $tableName == "chef") {
      $text = $_GET['text-chef'];
      $text = "%" . $text . "%";
      $query = "SELECT $columnName FROM $tableName 
      WHERE (CONCAT(prenom, ' ', nom) LIKE ? OR CONCAT(nom, ' ', prenom) LIKE ? OR email LIKE ?)
      ORDER BY id DESC";
      $stmt = $conn->prepare($query);
      $stmt->bind_param('sss', $text, $text, $text);
   }
   else {
      $query = "SELECT $columnName FROM $tableName";
      if ($tableName == "utilisateur" && $_SESSION["role"] == "chef") {
         $id_chef = $_SESSION['ID'];
         $query = $query . " WHERE id_chef = $id_chef";
      }
      $query = $query . " ORDER BY id DESC";
      $stmt = $conn->prepare($query);
   }

   if($stmt->execute()== true){ 
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
         $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
         $msg= $row;
      } else {
         $msg= "Aucune donnée trouvée."; 
      }
   }else{
   $msg= mysqli_error($conn);
   }
   }
   return $msg;
}

?>