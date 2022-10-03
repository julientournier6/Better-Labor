<!DOCTYPE html>
<?php
session_start();
include('config.php');
include('fetchdata.php');

if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1){
  redirect('profile.php');
}

$tableName="request";
$columns= ['datetime', 'user_id','room_id','room_duration','price', 'comments'];
$fetchData2 = fetch_data($conn, $tableName, $columns);
?>

<?php include ('nav.php');?>
<div class="center">
<a class="link" href="panel.php">Back to panel</a>
<h3>Room Requests</h3>
<div class="roomrequestscontainer">
      <table class="table table-bordered">
       <thead><tr>
         <th>Date and Time</th>
         <th>User ID</th>
         <th>Room Number</th>
         <th>Duration in hours</th>
         <th>Total price</th>
         <th>Additional Information,Notes,Comments</th>
    </thead>
    <tbody>
  <?php
      if(is_array($fetchData2)){      
      $sn=1;
      foreach($fetchData2 as $data){
    ?>
      <tr>
      <td><?php echo $data['datetime']??''; ?></td>
      <td><?php echo $data['user_id']??''; ?></td>
      <td><?php echo $data['room_id']??''; ?></td>
      <td><?php echo $data['room_duration']??''; ?></td>
      <td><?php echo $data['price']??''; ?></td>
      <td><?php echo nl2br(htmlentities($data['comments'], ENT_QUOTES, 'UTF-8'))??''; ?></td>
     </tr>
     <?php
      $sn++;}}else{ ?>
      <tr>
        <td colspan="8">
    <?php echo $fetchData2; ?>
  </td>
    <tr>
    <?php
    }?>
    </tbody>
     </table>
   </div>
</div>
</body>
</html>