<?php
class FAQManager {
  public $conn = null;

  public function connect() {
    require('config.php');
    $this->conn = $conn;
  }

  public function display_public() {
    $q = "SELECT * FROM categorie ORDER BY position ASC";
    $r_categorie = $this->conn->query($q);
    $entry_display = "";
    if ( $r_categorie != false && $r_categorie->num_rows > 0 ) {
      while ( $a_categorie = mysqli_fetch_assoc($r_categorie) ) {
        $categorie = stripslashes($a_categorie['nom']);
        $categorie_id = stripslashes($a_categorie['ID']);
        $q_question = "SELECT * FROM question WHERE ID_categorie = $categorie_id ORDER BY position ASC";
        $r_question = $this->conn->query($q_question);
        if ( $r_categorie != false && $r_question->num_rows > 0 ) {
        while ( $a_question = mysqli_fetch_assoc($r_question) ) {
          $sujet = stripslashes($a_question['sujet']);
          $reponse = stripslashes($a_question['reponse']);
          $entry_display .= <<<ENTRY_DISPLAY
      <div class="post">
        <h2>
          
        </h2>
        <p>
          
        </p>
    </div>
ENTRY_DISPLAY;
        }
      }
    } 
  }
    else {
      $entry_display = <<<ENTRY_DISPLAY
    <h2> Nous sommes désolés, aucune question n a été trouvée</h2>
    <p>
      Soit il y a un problème de connexion avec la base de données, soit aucune question n a été ajoutée.
    </p>
ENTRY_DISPLAY;
    }
    return $entry_display;
  }

  public function display_admin() {
    $q_categorie = "SELECT * FROM categorie ORDER BY position ASC";
    $r_categorie = $this->conn->query($q_categorie);
    $entry_display = "";
    if ( $r_categorie != false && $r_categorie->num_rows > 0 ) {
      while ( $a_categorie = mysqli_fetch_assoc($r_categorie) ) {
        $categorie = $a_categorie['nom'];
        $categorie_id = stripslashes($a_categorie['ID']);
        $entry_display .= <<<ADMIN_FORM
<form action="{$_SERVER['PHP_SELF']}" method="post" id="category-form-$categorie_id" name="save-category">
<input type="hidden" id="contentid" name="id" value="$categorie_id">
<div class="category-header">
  <h2 class="category-title" id="category-title-$categorie_id">$categorie</h2>
  <div class="side-buttons">
    <a class="side-button edit" onclick="editCategory()">
      <img src="images/edit.svg" id="edit-category-$categorie_id">
      <p class="info">Edit</p>
    </a>
    <a class="side-button delete" onclick="deleteCategory()">
      <img src="images/delete.svg">
      <p class="info">Delete</p>
    </a>
    <a class="side-button move-up">
      <img src="images/move-up.svg">
      <p class="info">Move</p>
    </a>
    <a class="side-button move-down">
      <img src="images/move-down.svg">
      <p class="info">Move</p>
    </a>
  </div>
</div>
<hr class="category-line">
</form>
ADMIN_FORM;
        $q_question = "SELECT * FROM question WHERE ID_categorie = $categorie_id ORDER BY position ASC";
        $r_question = $this->conn->query($q_question);
        if ( $r_question != false && $r_question->num_rows > 0 ) {
          while ( $a_question = mysqli_fetch_assoc($r_question) ) {
            $question_id = stripslashes($a_question['ID']);
            $sujet = stripslashes($a_question['sujet']);
            $reponse = stripslashes($a_question['reponse']);
          $entry_display .= <<<ADMIN_FORM
<form action="{$_SERVER['PHP_SELF']}" method="post" id="question-form-$question_id" name="save-question">
<div class="question-box">
  <button class="question-management-button">
    <p class="question-title" id="question-title-$question_id">$sujet</p>
    <div class="side-buttons">
      <a class="side-button edit" href="#" onclick="editQuestion()">
        <img class="smaller" id="edit-question-$question_id" src="images/edit.svg">
        <p class="info">Edit</p>
      </a>
      <a class="side-button delete" onclick="deleteQuestion()">
        <img class="smaller" id="delete-question-$question_id" src="images/delete.svg">
        <p class="info">Delete</p>
      </a>
      <a class="side-button move-up">
        <img class="smaller" src="images/move-up.svg">
        <p class="info">Move</p>
      </a>
      <a class="side-button move-down">
        <img class="smaller" src="images/move-down.svg">
        <p class="info">Move</p>
      </a>
    </div>
  </button>
  <div class="question-content-input" id="question-content-input-$question_id">
    <textarea name="reponse" class="question-content-text" rows="11">$reponse</textarea>
    <button class="save-button" id="save-button-$question_id">Sauvegarder</button>
  </div>
</div>
</form>
ADMIN_FORM;
  return $entry_display;
          }
        }
      }
    }
  }

  public function addQuestion($p, $categ_id) {
    if (isset($p['sujet'])) {
      $sujet = $this->conn->real_escape_string($p['sujet']);
    }
    if ($p['reponse']) {
      $reponse = $this->conn->real_escape_string($p['reponse']);
    }
    if ( $sujet && $reponse ) {
      $created = date('y-m-d h:i:s');
      $sql = "INSERT INTO question (category, title, bodytext, created) VALUES ('$sujet','$reponse','$created')";
      $query_new_content_insert = $this->conn->query($sql);
      if ($query_new_content_insert) {
        echo "Une nouvelle question a bien été ajoutée";
      } else {
        echo "La question n'a pas pu être ajoutée";
      }
      return $query_new_content_insert;
    } else {
      return false;
    }
  }

  public function saveCategory($p) {
    include('config.php');
    $id = $p["id"];
    $name = $this-> conn->real_escape_string($p["name"]);
    $messages = array();
    $sql = "UPDATE category SET name = '$name' WHERE ID = '$id'";
    $query_update = $conn->query($sql);
    if (!$name) {return ;}
    if ($query_update) {
      array_push($message, "La catégorie a bien été modifiée");
    }
    else {
      array_push($messages, "Désolé, la catégorie n'a pas pu être modifiée");
    }
  }
public function saveQuestion($p) {
  include('config.php');
  $id = $p["id"];
  $sujet = $this->conn->real_escape_string($p["name"]);
  $reponse = $this->conn->real_escape_string($p["reponse"]);
  $messages = array();
  $sql = "UPDATE question SET sujet = '$sujet', reponse = '$reponse' WHERE ID = '$id'";
  $query_update = $this->conn->query($sql);
  if (!$sujet || !$reponse) {return;}
  if ($query_update) {
    array_push($message, "La catégorie a bien été modifiée");
  }
  else {
    array_push($messages, "Désolé, la catégorie n'a pas pu être modifiée");
  }
}

public function deleteCategory($id) {
  include('config.php');
  $sql = "DELETE FROM categorie WHERE id = '$id'";
  $q = $conn->query($sql);
  if ($q) {
    array_push($messages, "La catégorie a bien été supprimée");
  }
  else {
    array_push($messages, "Désolé, la catégorie n a pas pu être supprimée");
  }
}
public function deleteQuestion($id) {
  include('config.php');
  $sql = "DELETE FROM question WHERE id = '$id'";
  $q = $conn->query($sql);
  if ($q) {
    array_push($messages, "La question a bien été supprimée");
  }
  else {
    array_push($messages, "Désolé, la question n'a pas pu être supprimée");
  }
}

public function moveCategory($up) {
  include('config.php');
  $id = $_POST["id"];
  if ($up) {
    $position = $_POST["position"] + 1;
  }
  else {
    $position = $_POST["position"] - 1;
  }
  $sql = "SELECT * FROM category WHERE ID = '$id'";
  $sql = "UPDATE category SET position = '$position' WHERE position = '$position'";
  $query_update = $conn->query($sql);
  if ($query_update) {
    // rafraichir page si besoin
  }
}

}

?>