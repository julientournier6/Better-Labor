<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel = "stylesheet" href = "../general.css">
    <link rel = "stylesheet" href = "../espace-membre/inscription.css">
    <link rel = "stylesheet" href = "../espace-chef/ajout_employés.css">
</head>
<body>
    <div class="log-container">
        <div class="logo">
            <img class="better" src="../logo.jpg">
        </div>

        <div class="title"><b>Ajout d'employés</b></div>

        <div class="inputs">
        
            <form action="" method="post" id="inscription">
                <input type="text" placeholder="Nom" name="nom" id="nom" required>
                <br> 
                <input type="text" placeholder="Prénom" name="prenom" id="prenom" required>
                <br>
                <input type="text" placeholder="Date de naissance" name="date_naiss" id="date_naiss" required>
                <br>
                <input type="text" placeholder="Adresse e-mail" name="email" id="email" required>
                <br>
                <input type="text" placeholder="Numéro de téléphone" name="tel" id="tel" required>
                <br>
                <div class = "radio">
                    <p>Gender :</p> 
                    <input type="radio" name="gender" value="female"><p>Female</p>
                    <input type="radio" name="gender" value="male"><p>Male</p>
                    <input type="radio" name="gender" value="other"><p>Other</p>
                </div>
                <button type="submit" name="inscription"><b>Ajouter</b></button>
            </form>
            <a class="link" href="../espace-chef/MesEmployés.php">Annuler</a>
            <br>
        </div>
    </div>

</body>
</html>