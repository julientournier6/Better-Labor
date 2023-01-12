<?php
$bdd = new PDO('mysql:host=localhost;dbname=musique','root','');
$allusers = $bdd->query("SELECT * FROM personne");
$allusers2 = $bdd->query("SELECT * FROM personne");
$allusers3 = $bdd->query("SELECT * FROM personne");
    ?>

<!DOCTYPE html>

<html>

    <head>
        <meta charset = "utf-8">
        <meta name = "viewport" content="width=device-width">
        <link rel = "stylesheet" href = "espace-chef.css">
    </head>

    <body>
        <div class = "input">
            <?php
            if(isset($_POST['search']) AND !empty($_POST['search'])){
                $recherche = htmlspecialchars($_POST['search']);
                $recherche = trim($_POST['search']);
                $recherche = stripslashes($_POST['search']);
                $allusers = $bdd->query("SELECT * FROM personne WHERE nomPersonne LIKE '%$recherche%' ORDER BY id_Personne");
            }

            if(isset($_POST['search2']) AND !empty($_POST['search2'])){
                $recherche2 = htmlspecialchars($_POST['search2']);
                $recherche2 = trim($_POST['search2']);
                $recherche2 = stripslashes($_POST['search2']);
                $allusers2 = $bdd->query("SELECT * FROM personne WHERE prenomPersonne LIKE '%$recherche2%' ORDER BY id_Personne");
            }

            if(isset($_POST['search3']) AND !empty($_POST['search3'])){
                $recherche3 = htmlspecialchars($_POST['search3']);
                $recherche3 = trim($_POST['search3']);
                $recherche3 = stripslashes($_POST['search3']);
                $allusers3 = $bdd->query("SELECT * FROM personne WHERE dateNaissance LIKE '%$recherche3%' ORDER BY id_Personne");
            }
            ?>

            <form method = "POST"> <!--Définition d'un formulaire-->
                <input type = "search" name = "search" placeholder = "Recherche par nom"> <!--Définition de la barre de recherche (placeholder : ce que voit l'utilisateur)-->
                <input type = "search" name = "search2" placeholder = "Recherche par prénom">
                <input type = "search" name = "search3" placeholder = "Recherche par date de naissance">
                <input type = "submit" name = "envoyer" ><!--boutton envoyer-->
            </form>
        </div>

        <div class = "affichage">
            <?php
                if($allusers -> rowCount() > 0){  /* si le nombre d'utilisateurs relevés est > 0 */
                    while($users = $allusers -> fetch()){ /* tant que la variable users = la variable allusers, on récupère toutes les données */
                        ?>
                        <p><?php echo $users['id_Personne']; ?></p> <!--affiche la liste des utilisateurs contenant la condition de la recherche-->
                        <p><?php echo $users['nomPersonne']; ?></p>
                        <p><?php echo $users['prenomPersonne']; ?></p>
                        <p><?php echo $users['dateNaissance']; ?></p>
                        <?php
                    }
                }
                elseif ($allusers2 -> rowcount() > 0){
                    while($users = $allusers2 -> fetch()){
                        ?>
                        <p><?php echo $users['id_Personne']; ?></p> <!--affiche la liste des utilisateurs contenant la condition de la recherche-->
                        <p><?php echo $users['nomPersonne']; ?></p>
                        <p><?php echo $users['prenomPersonne']; ?></p>
                        <p><?php echo $users['dateNaissance']; ?></p>
                        <?php
                    }
                }
                elseif ($allusers3 -> rowcount() > 0){
                    while($users = $allusers3 -> fetch()){
                        ?>
                        <p><?php echo $users['id_Personne']; ?></p> <!--affiche la liste des utilisateurs contenant la condition de la recherche-->
                        <p><?php echo $users['nomPersonne']; ?></p>
                        <p><?php echo $users['prenomPersonne']; ?></p>
                        <p><?php echo $users['dateNaissance']; ?></p>
                        <?php
                    }
                }
                else{
                    ?>
                    <p>Aucun utilisateur trouvé</p>
                    <?php
                }
            ?>
        </div>
    </body>

</html>