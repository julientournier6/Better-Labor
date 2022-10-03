<!DOCTYPE html>

<?php
session_start();
include ('nav.php');
include('config.php');
include('fetchdata.php');

if(!isset($_SESSION["admin"]) || $_SESSION["admin"] != 1){
  redirect('profile.php');
}
$messages = array();
$tableName="user";
$columns= ['id', 'email','firstname','lastname','subscribed'];
$fetchData = fetch_data($conn, $tableName, $columns);

if (isset($_POST["uploadpicture"])) {
  $target_dir = "gallery/";
  $target_file = $target_dir . basename($_FILES["picture"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (file_exists($target_file)) {
    $messages[] = "Sorry, the file already exists.";
    $uploadOk = 0;
  }
  
  if ($_FILES["picture"]["size"] > 1500000) {
    $messages[] = "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "png" && $imageFileType != "bmp" && $imageFileType != "webp") {
    $messages[] = "Sorry, please import the picture as a jpg, jpeg, gif, png, bmp or webp instead.";
    $uploadOk = 0;
  }
  
  if ($uploadOk == 0) {
    $messages[] = "The upload didn't work, sorry.";
  } else {
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
      $messages[] = "The file ". htmlspecialchars( basename( $_FILES["picture"]["name"])). " has been uploaded to the gallery.";
    }
  }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST["sendletter"])) {
    $target_dir = "newsletters/";
    $target_file = $target_dir . basename($_FILES["userfile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if (file_exists($target_file)) {
      $messages[] = "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    if ($_FILES["userfile"]["size"] > 600000) {
      $messages[] = "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    if($imageFileType != "pdf" ) {
      $messages[] = "Sorry, please import the letter as a PDF instead!";
      $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
      $messages[] = "The sending didn't work, sorry.";
    } else {
      if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
        $messages[] = "The file ". htmlspecialchars( basename( $_FILES["userfile"]["name"])). " has been uploaded.";
        $subject = $_POST["subject"];
        $body = $_POST["body"];
        $file = $target_file;
        $result = mysqli_query($conn, "SELECT * FROM user");
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'com540test@gmail.com';                     
        $mail->Password   = 'justatest';                               
        $mail->SMTPSecure = 'tls';          
        $mail->Port       = 587;
        $mail->setFrom('com540test@gmail.com', 'COM540');
        $mail->addAttachment($file);         
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        try{
          while ($row = mysqli_fetch_object($result))
          {
            if ($row->subscribed == 1) {
              $mail->addAddress($row->email);
              $mail->Body    = 'Hello '. $row->firstname . ' ' . $row->lastname . '! ' . $body . '<br>Y Saith Seren<br>Canolfan Gymraeg Wrecsam<br>18 Stryd Caer<br>Wrecsam<br>LL13 8BG<br>01978 447006<br>Log on <a href="http://www.saithseren.org.uk/">our website</a> if you wish to unsubscribe!';
              $mail->AltBody = 'Hello '. $row->firstname . ' ' . $row->lastname . '! ' . $body . 'Y Saith Seren
              Canolfan Gymraeg Wrecsam
              18 Stryd Caer
              Wrecsam
              LL13 8BG
              01978 447006
              Log on http://www.saithseren.org.uk/ if you wish to unsubscribe!';
            }
          }
          $mail->send();
          $messages[] = "Message has been sent";
        } catch (Exception $e) {
          $messages[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      } else {
        $messages[] = "Sorry, there was an error uploading the newsletter.";
      }
    }
  }
?>


<div class="center">
<?php
if ($messages) {
          foreach ($messages as $message) {
              echo('<p class="error">' . $message . '</p>');
          }
        }
?>

<br>
<div>
  <a class="link" href="roomrequests.php">Room Requests</a>
</div>

<br>

<div class="bigcontainer">
  <h4>Send a newsletter</h4>
<form enctype="multipart/form-data" method="post" action="" name="sendletter-form">
<div class="form-element">
    <label for="subject">Mail subject</label>
    <input type="text" id="subject" name="subject" value="Saith Seren Newsletter" required class = "white" />
</div>
<div class="form-element">
  <label for="body">Mail body</label>
    <textarea rows = "8" cols = "150" name = "body" id="body", required class = "white">Here is your monthly newsletter. We hope to see you in our pub soon!</textarea>
</div>
<div class="form-element">
    <label for="file">Import the newsletter</label>
    <input type="file" id="file" name="userfile" required />
</div>
<br>
<div class="form-element">
<button type="submit" name="sendletter" value="sendletter">Send newsletter</button>
</div>
</form>
</div>

<br>
<br>
<br>
<br>

<div class="bigcontainer">
  <h4>Upload a picture to the gallery</h4>
<form enctype="multipart/form-data" method="post" action="" name="sendletter-form">
<div class="form-element">
    <label for="picture">Import a picture (caption = file name)</label>
    <input type="file" id="picture" name="picture" required/>
</div>
<br>
<button type="submit" name="uploadpicture" value="uploadpicture">Upload</button>
</form>
</div>

<h3>Users Table</h3>
<div class="container">
      <table class="table-bordered">
       <thead><tr><th>ID</th>
         <th>First Name</th>
         <th>Last Name</th>
         <th>Email</th>
         <th>Subscribed</th>
    </thead>
    <tbody>
  <?php
      if(is_array($fetchData)){      
      $sn=1;
      foreach($fetchData as $data){
    ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['firstname']??''; ?></td>
      <td><?php echo $data['lastname']??''; ?></td>
      <td><?php echo $data['email']??''; ?></td>
      <td><?php echo $data['subscribed']??''; ?></td>
     </tr>
     <?php
      $sn++;}}else{ ?>
      <tr>
        <td colspan="8">
    <?php echo $fetchData; ?>
  </td>
  </tr>
    <?php
    }?>
    </tbody>
     </table>
</div>
</br>
</br>

<p class="bigtext">Number of subscribers : <?php echo subscribers($conn) ?> </p> 

</div>
</body>
</html>