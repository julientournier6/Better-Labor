<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href = "../tableau.css"/>
    <link rel ="stylesheet" href = "../general.css"/>
    <script src="../tools.js"></script>
    <title>BetterLabor</title>
</head>

  <body>
<?php
$messages = array();
include("../database/fetch_data.php");
include("../database/config.php");
include("../database/tools.php");
$tableName="chef";
$columns= ['id', 'email','nom','prenom','statut'];
$fetchData = fetch_data($conn, $tableName, $columns);
?>
    <div class ="conteneur">
        <div class="conteneur-tableau">
            <table class="tableau">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                
                <tbody>
        <?php
            if(is_array($fetchData)){      
            foreach($fetchData as $data){
        ?>
                    <tr class="row" id="$data['id']">
                        <td><?php echo $data['nom']; ?></td>
                        <td><?php echo $data['prenom']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php 
                        if ($data['statut'] == 0) {
                            echo '<img class ="tailleCercle" src = "../images/résultat-vert.png">';
                        }
                        else {
                            echo '<img class ="tailleCercle" src = "../images/résultat-rouge.png">';    
                        }
                            ?>
                        </td> 
                    </tr>
        <?php
        }}else{ ?>
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
   
            <p class = "nombreEmploye">
                <?php
                echo count_rows($conn, "chef");
                ?>
            </p>
            <div class="boutons_employes">
                <button class="AjoutEmployés bouton-important">
                    Ajouter un chef
                </button>
            </div>
    </div>

  </body>
</html>
<script src="gestion_chefs.js"></script>
<script>
addEvent('row', rowClick)
</script>