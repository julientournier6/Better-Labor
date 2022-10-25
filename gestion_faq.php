
<?php
      session_start();
      include('database/CMS.php');
      $obj = new simpleCMS();
      $obj->connect();

      if (isset($_POST["add"]))
      {$obj->write($_POST, $categ);}
      if (isset($_POST["update"])) 
      {$obj->update($_POST, $_POST["contentid"]);}
      
      if (isset($_SESSION['admin']) AND $_SESSION['admin'] == 1) {
        echo $obj->display_admin($categ);
      } 
      else {
        echo $obj->display_public($categ);
      }
    ?>