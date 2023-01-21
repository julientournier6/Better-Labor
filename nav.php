<html lang="fr">
<head>
    <title>Better Labor</title>
    <meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="stylesheet" href="footer.css" type="text/css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
</head>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
    include('barre profil.php');
}
else {
    include('barre accueil.php');
}
function make_footer($pushed) {
    if ($pushed) {
        echo '<div class="footer pushed">';
    }
    else {
        echo '<div class = "footer">';
    }
    $entry_display = <<<FOOTER
    <div class = "section_help">   
    </div>
    <div class = "help">
        <div class = "a1">
            <a class="footer-link" href = "cgu.php">Conditions d'utilisation</a>
        </div>
        <div class = "a2">
            <a class="footer-link" href = "contact.php">Contact</a>
        </div>
        <div class = "a3">
            <a class="footer-link" href = "faq.php">FAQ</a>
        </div>
        <div class = "a4">
            <a class="footer-link" href = "mentions_legales.php">Mentions légales</a>
        </div>
    </div>
</div>
FOOTER;
        echo $entry_display;
}

?>
</html>
