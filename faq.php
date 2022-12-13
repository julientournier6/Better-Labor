<!doctype html>

<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>FAQ Better Labor</title>
  <link rel="stylesheet" href="faq.css">
  <script src="faq.js"></script>
</head>
<body class="background">

  <div class="faq">
    <h1 class="title">Support Better Labor</h1>
    <?php
session_start();
include('espace-admin/FAQManager.php');
$obj = new FAQManager();
$obj->connect("database/config.php");
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
        <button class="help-button">
        J'ai besoin d'aide
        </button>
        </div>
    </div>
<?php
include("footer.php");
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