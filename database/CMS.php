<?php
class CMS {

  public function connect() {
    include('config.php');
    $this->conn = $conn;
  }

  public function display_public() {
    $q_categorie = "SELECT * FROM categorie ORDER BY position ASC";
    $r_categorie = $this->conn->query($q_categorie);
    $entry_display = "";
    if ( $r_categorie != false && $r_categorie->num_rows > 0 ) {
      while ( $a_categorie = mysqli_fetch_assoc($r_categorie) ) {
        $categorie = stripslashes($a_categorie['nom']);
        $categorie_id = stripslashes($a_categorie['ID']);
        $q_question = "SELECT * FROM question WHERE ID_categorie = $categorie_id ORDER BY position ASC";
        $r_question = $this->conn->query($q_question);
        if ( $r_categorie != false && $r_categorie->num_rows > 0 ) {
        while ( $a_question = mysqli_fetch_assoc($r_question) ) {
          $sujet = stripslashes($a_question['sujet']);
          $reponse = stripslashes($a_question['reponse']);
          $entry_display .= <<<ENTRY_DISPLAY
      <div class="post">
        <h2>
          $title
        </h2>
        <p>
          $bodytext
        </p>
    </div>
  ENTRY_DISPLAY;
        }
      }
    } 
  }
    else {
      $entry_display = <<<ENTRY_DISPLAY
    <h2> Nous sommes désolés, aucune question n'a été trouvée</h2>
    <p>
      Soit il y a un problème de connexion avec la base de données, soit aucune question n'a été ajoutée.
    </p>
    ENTRY_DISPLAY;
    }
    return $entry_display;
    }

  public function display_admin($categ) {
    $q = "SELECT * FROM question ORDER BY position DESC";
    $r = $this->conn->query($q);
    $entry_display = "";
    if ( $r != false && $r->num_rows > 0 ) {
      while ( $a = mysqli_fetch_assoc($r) ) {
        $category = stripslashes($a['category']);
        if ($categ == $category) {
        $title = stripslashes($a['title']);
        $bodytext = stripslashes($a['bodytext']);
        $id = stripslashes($a['id']);
        $entry_display .= <<<ADMIN_FORM
    <form action="{$_SERVER['PHP_SELF']}" method="post">
    <input type="hidden" id="contentid" name="contentid" value="$id">
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" maxlength="150" value="$title"/>
      <div class="clear"></div>
     
      <label for="bodytext">Body Text:</label><br />
      <textarea name="bodytext" id="bodytext" rows="8" cols="100">$bodytext</textarea>
      <div class="clear"></div>
      
      <input type="submit" name="update" value="Update this paragraph" />
    </form>
    
    <br>
ADMIN_FORM;
        }
      }
      $entry_display .= <<<ADMIN_FORM
      <form action="{$_SERVER['PHP_SELF']}" method="post">
      
        <label for="title">Title:</label><br />
        <input name="title" id="title" type="text" maxlength="150" />
        <div class="clear"></div>
       
        <label for="bodytext">Body Text:</label><br />
        <textarea name="bodytext" id="bodytext"></textarea>
        <div class="clear"></div>
        
        <input type="submit" name="add" value="Add this paragraph" />
      </form>
      
      <br>
  
ADMIN_FORM;
  return $entry_display;
  }
  }

  public function write($p, $categ) {
    if (isset($p['title']))
      $title = $this->conn->real_escape_string($p['title']);
    if ($p['bodytext'])
      $bodytext = $this->conn->real_escape_string($p['bodytext']);
    if ( $title && $bodytext ) {
      $created = date('y-m-d h:i:s');
      $sql = "INSERT INTO content (category, title, bodytext, created) VALUES ('$categ','$title','$bodytext','$created')";
      $query_new_content_insert = $this->conn->query($sql);
      if ($query_new_content_insert) {
        echo "New content has been added.";
      } else {
        echo "Sorry, new content was not added.";
      }
      return $query_new_content_insert;
    } else {
      return false;
    }
  }

  public function update($p, $id) {
    if ($p['title'] )
      $title = $this->conn->real_escape_string($p['title']);
    if ($p['bodytext'])
      $bodytext = $this->conn->real_escape_string($p['bodytext']);
    if ( $title && $bodytext ) {
      $sql = "UPDATE content SET title = '$title', bodytext = '$bodytext' WHERE id = '$id'";
      $query_update_content = $this->conn->query($sql);
      if ($query_update_content) {
        echo "New content has been added.";
      } else {
        echo "Sorry, new content was not added.";
      }
      return $query_update_content;
    } else {
      return false;
    }
  }

}

?>