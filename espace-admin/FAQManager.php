<?php
class FAQManager
{
  public $conn = null;

  public function connect($conn)
  {
    $this->conn = $conn;
  }

  public function display_public()
  {
    $q = "SELECT * FROM categorie ORDER BY position ASC";
    $r_categorie = $this->conn->query($q);
    $entry_display = "";
    if ($r_categorie != false && $r_categorie->num_rows > 0) {
      while ($a_categorie = mysqli_fetch_assoc($r_categorie)) {
        $nom = stripslashes($a_categorie['nom']);
        $categorie_id = stripslashes($a_categorie['ID']);
        $entry_display .= <<<ENTRY_DISPLAY
        <h2 class="category-title">$nom</h2>
        <hr class="category-line">
ENTRY_DISPLAY;
        $q_question = "SELECT * FROM question WHERE ID_categorie = $categorie_id ORDER BY position ASC";
        $r_question = $this->conn->query($q_question);
        if ($r_categorie != false && $r_question->num_rows > 0) {
          while ($a_question = mysqli_fetch_assoc($r_question)) {
            $sujet = stripslashes($a_question['sujet']);
            $reponse = stripslashes($a_question['reponse']);
            $question_id = stripslashes($a_question['ID']);
            $entry_display .= <<<ENTRY_DISPLAY
            <div class="question-box">
            <button class="question-button" id="question-button-$question_id">
              <p class="question-title">$sujet</p>
              <img class="img-defilement" src="images/defilement-bas.png" alt="ouvrir question" id="defilement-$question_id">
            </button>
            <div class="question-content"><p class="question-content-text">$reponse</p></div>
          </div>
ENTRY_DISPLAY;
          }
        }
      }
    } else {
      $entry_display = <<<ENTRY_DISPLAY
    <h2> Nous sommes désolés, aucune question n a été trouvée</h2>
    <p>
      Soit il y a un problème de connexion avec la base de données, soit aucune question n a été ajoutée.
    </p>
ENTRY_DISPLAY;
    }
    return $entry_display;
  }

  public function display_admin()
  {
    $q_categorie = "SELECT * FROM categorie ORDER BY position ASC";
    $r_categorie = $this->conn->query($q_categorie);
    $entry_display = "";
    $num_rows = $r_categorie->num_rows;
    $i = 0;
    if ($r_categorie != false && $r_categorie->num_rows > 0) {
      while ($a_categorie = mysqli_fetch_assoc($r_categorie)) {
        $categorie = $a_categorie['nom'];
        $categorie_id = stripslashes($a_categorie['ID']);
        $entry_display .= <<<ADMIN_FORM
<form action="{$_SERVER['PHP_SELF']}" method="post" id="category-form-$categorie_id" name="save-category">
<input type="hidden" name="id" value="$categorie_id">
<div class="category-header">
  <h2 class="category-title" id="category-title-$categorie_id">$categorie</h2>
  <div class="side-buttons">
    <a class="side-button edit editCategory">
      <img src="../images/edit.svg" id="edit-category-$categorie_id">
      <p class="info-hover">Edit</p>
    </a>
    <a class="side-button delete deleteCategory">
      <img src="../images/delete.svg" id="delete-category-$categorie_id">
      <p class="info-hover">Delete</p>
    </a>
    <a class="side-button move-up moveupCategory" id="moveup-category-$categorie_id">
      <img src="../images/move-up.svg">
      <p class="info-hover">Move</p>
    </a>
    <a class="side-button move-down movedownCategory" id="moveup-category-$categorie_id">
      <img src="../images/move-down.svg">
      <p class="info-hover">Move</p>
    </a>
  </div>
</div>
<hr class="category-line">
</form>
ADMIN_FORM;
        $q_question = "SELECT * FROM question WHERE ID_categorie = $categorie_id ORDER BY position ASC";
        $r_question = $this->conn->query($q_question);
        if ($r_question != false && $r_question->num_rows > 0) {
          while ($a_question = mysqli_fetch_assoc($r_question)) {
            $question_id = stripslashes($a_question['ID']);
            $sujet = stripslashes($a_question['sujet']);
            $reponse = stripslashes($a_question['reponse']);
            $entry_display .= <<<ADMIN_FORM
<form action="{$_SERVER['PHP_SELF']}" method="post" id="question-form-$question_id">
<input type="hidden" name="id" value="$question_id">
<div class="question-box">
  <button type="button" class="question-management-button">
    <p class="question-title" id="question-title-$question_id">$sujet</p>
    <div class="side-buttons">
      <a href="#" class="side-button edit editQuestion">
        <img class="smaller" id="edit-question-$question_id" src="../images/edit.svg">
        <p class="info-hover">Edit</p>
      </a>
      <a href="#" class="side-button delete deleteQuestion">
        <img class="smaller" id="delete-question-$question_id" src="../images/delete.svg">
        <p class="info-hover">Delete</p>
      </a>
      <a href="#" class="side-button move-up moveupQuestion" id="moveup-question-$question_id">
        <img class="smaller" src="../images/move-up.svg">
        <p class="info-hover">Move</p>
      </a>
      <a href="#" class="side-button move-down movedownQuestion" id="movedown-question-$question_id">
        <img class="smaller" src="../images/move-down.svg">
        <p class="info-hover">Move</p>
      </a>
    </div>
  </button>
  <div class="question-content-input" id="question-content-input-$question_id">
    <textarea name="reponse" class="question-content-text" rows="11">$reponse</textarea>
    <button type="submit" name="save-question" class="save-button" id="save-question-$question_id">Sauvegarder</button>
  </div>
</div>
</form>
ADMIN_FORM;
          }
        }
        $entry_display .= <<<ADMIN_FORM
<button type="button" class="add-question" id="add-question-$categorie_id">Nouvelle question</button>
ADMIN_FORM;
        $i++;
        if ($i == $num_rows) {
          $entry_display .= <<<ADMIN_FORM
<button type="button" class="add-category" id="add-category-$categorie_id">Nouvelle catégorie</button>
ADMIN_FORM;
        }
      }
    }
    return $entry_display;
  }

  public function addQuestion($id_categorie)
  {
    $sujet = "Insérez une question.";
    $reponse = "Insérez une réponse.";
    if ($sujet && $reponse) {
      $sql = "SELECT MAX(position) AS max_position FROM question WHERE ID_categorie = '$id_categorie'";
      $result = $this->conn->query($sql);
      $result_row = $result->fetch_array();
      $position = $result_row["max_position"] + 1;
      $sql = "INSERT INTO question (ID_categorie, position, sujet, reponse) VALUES ('$id_categorie', '$position', '$sujet','$reponse')";
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

  public function addCategory()
  {
    $nom = "Nom de catégorie";
    if ($nom) {
      $sql = "SELECT MAX(position) AS max_position FROM categorie";
      $result = $this->conn->query($sql);
      $result_row = $result->fetch_array();
      $position = $result_row["max_position"] + 1;
      $sql = "INSERT INTO categorie (position, nom) VALUES ('$position', '$nom')";
      $query_new_content_insert = $this->conn->query($sql);
      if ($query_new_content_insert) {
        echo "Une nouvelle catégorie a bien été ajoutée";
      } else {
        echo "La catégorie n'a pas pu être ajoutée";
      }
      return $query_new_content_insert;
    } else {
      return false;
    }
  }

  public function saveCategory($p)
  {
    $id = $p["id"];
    $name = $this->conn->real_escape_string($p["nom"]);
    $messages = array();
    $sql = "UPDATE categorie SET nom = '$name' WHERE ID = '$id'";
    $query_update = $this->conn->query($sql);
    if (!$name) {
      return;
    }
    if ($query_update) {
      array_push($messages, "La catégorie a bien été modifiée");
    } else {
      array_push($messages, "Désolé, la catégorie n'a pas pu être modifiée");
    }
  }
  public function saveQuestion($p)
  {
    $id = $p["id"];
    $sujet = $this->conn->real_escape_string($p["sujet"]);
    $reponse = $this->conn->real_escape_string($p["reponse"]);
    $messages = array();
    $sql = "UPDATE question SET sujet = '$sujet', reponse = '$reponse' WHERE ID = '$id'";
    $query_update = $this->conn->query($sql);
    if (!$sujet || !$reponse) {
      return;
    }
    if ($query_update) {
      array_push($messages, "La catégorie a bien été modifiée");
    } else {
      array_push($messages, "Désolé, la catégorie n'a pas pu être modifiée");
    }
  }

  public function deleteCategory($id)
  {
    $sql = "DELETE FROM categorie WHERE ID = '$id'";
    $q = $this->conn->query($sql);
    $messages = array();
    if ($q) {
      array_push($messages, "La catégorie a bien été supprimée");
    } else {
      array_push($messages, "Désolé, la catégorie n a pas pu être supprimée");
    }
  }
  public function deleteQuestion($id)
  {
    $sql = "DELETE FROM question WHERE ID = '$id'";
    $q = $this->conn->query($sql);
    $messages = array();
    if ($q) {
      array_push($messages, "La question a bien été supprimée");
    } else {
      array_push($messages, "Désolé, la question n'a pas pu être supprimée");
    }
  }

  public function moveCategory($id, $step)
  {
    $id = $_POST["id"];
    $sql = "SELECT * FROM categorie WHERE ID = '$id'";
    $messages = array();
    $result = $this->conn->query($sql);
    if ($result->num_rows == 1) {
      $categorie = $result->fetch_object();
      $position = $categorie->position;
      $newposition = $position + $step;
      $sql = "SELECT MAX(position) AS max_position FROM categorie";
      $result = $this->conn->query($sql);
      $result_row = $result->fetch_array();
      $max_position = $result_row["max_position"];
      if ($newposition == 0 || $newposition > $max_position) {
        return;
        //annuler si position n'a pas de sens
      }
      echo $position;
      echo $newposition;
      //On déplace d'abord la catégorie que l'utilisateur veut déplacer
      $sql = "UPDATE categorie SET position = '$newposition' WHERE position = '$position'";
      $query_update1 = $this->conn->query($sql);
      if ($query_update1) {
        //Puis on déplace la catégorie qui doit être déplacée dans l'autre sens pour prendre l'ancienne position de la catégorie qu'on vient de déplacer
        $sql = "UPDATE categorie SET position = '$position' WHERE position = '$newposition' AND NOT ID = '$id'";
        $query_update2 = $this->conn->query($sql);
        if ($query_update2) {
          $messages[] = "succès";
        }
      }
    }
  }


public function moveQuestion($id, $step)
{
  $id = $_POST["id"];
  $sql = "SELECT * FROM question WHERE ID = '$id'";
  $messages = array();
  $result = $this->conn->query($sql);
  if ($result->num_rows == 1) {
    $categorie = $result->fetch_object();
    $position = $categorie->position;
    $id_categorie = $categorie->ID_categorie;
    $newposition = $position + $step;
    $sql = "SELECT MAX(position) AS max_position FROM question WHERE ID_categorie = '$id_categorie'";
    $result = $this->conn->query($sql);
    $result_row = $result->fetch_array();
    $max_position = $result_row["max_position"];
    if ($newposition == 0 || $newposition > $max_position) {
      return;
      //annuler si position n'a pas de sens
    }
    echo $position;
    echo $newposition;
    //On déplace d'abord la catégorie que l'utilisateur veut déplacer
    $sql = "UPDATE question SET position = '$newposition' WHERE position = '$position' AND ID_categorie = '$id_categorie'";
    $query_update1 = $this->conn->query($sql);
    if ($query_update1) {
      //Puis on déplace la catégorie qui doit être déplacée dans l'autre sens pour prendre l'ancienne position de la catégorie qu'on vient de déplacer
      $sql = "UPDATE question SET position = '$position' WHERE position = '$newposition' AND NOT ID = '$id' AND ID_categorie = '$id_categorie'";
      $query_update2 = $this->conn->query($sql);
      if ($query_update2) {
        $messages[] = "succès";
      }
    }
  }
}
}

?>