<!doctype html>

<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FAQ Better Labor</title>
  <link rel="stylesheet" href="faq.css">
  <link rel="stylesheet" href="general.css">
  <script src="faq.js"></script>
</head>
<body>
<?php
include('nav.php');
?>

  <div class="faq">
    <h1 class="title">Support Better Labor</h1>
    <?php
include('espace-admin/FAQManager.php');
include('database/config.php');
$obj = new FAQManager();
$obj->connect($conn);
echo $obj->display_public();
?>
  </div>
    <div class="side-info">
        <img class="help" src="images/information.png" alt="info">
        <div class="side-help">
          <p class="help-question">
          Vous ne trouvez pas de réponse à votre question ?
          </p>
          <p class="help-contact">
          Contactez-nous directement par mail à contact.betterlabor@gmail.com
          </p>
          <button onclick="location.href='contact.php';" class="help-button">
          J'ai besoin d'aide
          </button>
        </div>
    </div>
<?php
make_footer(true);
?>
</body>
</html>
<script>
  var coll = document.getElementsByClassName("question-button");
  var i;
  
  for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", questionClick);
  }
  </script>