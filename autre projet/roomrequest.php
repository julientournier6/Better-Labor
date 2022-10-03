<!DOCTYPE html>
<?php
session_start();
include("nav.php");
if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == 1) {
if (isset($_POST["roomrequest"])) {
include('config.php');
$datetime = date("Y-m-d h:i:s", strtotime($_POST['datetime'])); 
$user_id = $_SESSION["id"];
$room_id = $_POST["room_id"];
$room_duration = $_POST["room_duration"];
$messages = array();
if ($_POST["organization"] == "charity") $price = $room_duration * 5;
else $price = $room_duration * 10;
$comments = $_POST["comments"];
$sql = "SELECT * FROM request WHERE datetime = '$datetime'";
$query_check_datetime = $conn->query($sql);
  if ($query_check_datetime->num_rows == 1) {
      $messages[] = "Sorry, that room request time spot is taken!";
  } else {
      $sql = "INSERT INTO request (datetime, user_id, room_id, room_duration, price, comments)
VALUES('" . $datetime . "', '" . $user_id . "', '" . $room_id . "', '" . $room_duration. "', '" . $price . "', '" . $comments . "');";
      $query_new_event_insert = $conn->query($sql);
      if ($query_new_event_insert) {
        $messages[] = "The request has been sent successfully.";
      } else {
        $messages[] = "Sorry, we could not send the request. Please go back and try again.";
      }
  }
}
}

if (isset($messages) && $messages) {
  foreach ($messages as $message) {
      echo('<p class="error">' . $message . '</p>');
  }
}
?>

<div class = "Prez">
			<p class = "prezeng">
      We have 5 rooms available for rent from 1 hour or longer periods;<br>
      Charities £5 per hour / Business Use £10 per hour<br>
      Full details - 01978 447006 / 7seren@gmail.com</p>
      </p>

			<p class = "prezgal"> 
      Mae gennym 5 ystafell sydd ar gael i’w llogi - wrth yr awr neu gyfnodau hwy;<br>
      Elusennau £5 yr awr / Busnesau £10 yr awr<br>
      Manylion llawn - 01978 447006 / 7seren@gmail.com<br>
      </p>
</div>


<?php if (isset($_SESSION['loggedin']) AND $_SESSION['loggedin'] == 1) {?>
  <div class="bigcontainer">
<form method="post" action="" name="roomrequest-form">
  <div class="form-element">
    <label>Room Number</label>
    <input class="white" class="white" type="number" name="room_id" min="1" max="5" required />
  </div>
  <div class="form-element">
    <label>Date and Time (check our opening hours)</label>
    <input class="white" type="datetime-local" name="datetime" required />
  </div>
  <div class="form-element">
    <label>Duration</label>
    <select class="white" name="room_duration" required>
    <option value="1">1 hour</option>
    <option value="2">2 hours</option>
    <option value="3">3 hours</option>
    <option value="4">4 hours</option>
    <option value="5">5 hours</option>
    <option value="6">6 hours</option>
    <option value="7">7 hours</option>
    <option value="8">8 hours</option>
    <option value="9">9 hours</option>
    <option value="10">10 hours</option>
    <option value="11">11 hours</option>
    <option value="12">12 hours</option>
    <option value="13">13 hours</option>
    <option value="14">14 hours</option>
    </select>
  </div>
  <div class="form-element">
    <label>Organization</label>
    <select class="white" name="organization" required>
    <option value="charity">Charity</option>
    <option value="business">Business</option>
    <option value="other">Other</option>
    </select>
  </div>
  <div class="form-element">
    <label for="comments">Additional information and comments</label>
    <br>
    <textarea class="white" rows = "8" cols = "150" name = "comments" id="comments", required>
Organization name
Telephone number
Additional comments</textarea>
  </div>
  <button class="white"  type="submit" name="roomrequest" value="roomrequest">Request</button>
</form>
</div>
<?php } else {?>
  <a class="center" href="profile.php">Log on if you want to request to hire a room</a>
<?php }?>
</body>
</html>