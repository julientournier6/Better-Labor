<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" href = "../tableau.css"/>
    <link rel ="stylesheet" href = "../general.css"/>
    <title>BetterLabor</title>
</head>

  <body>
<?php
$messages = array();
include("../database/fetch_data.php");
include("../database/config.php");
$tableName="chef";
$columns= ['email','nom','prenom','statut'];
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
                    <tr>
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
   
            <p class = "nombreEmploye">xx/50 employés</p>
            <div class="boutons_employes">
                <button class="AjoutEmployés bouton-important">
                    Ajouter des employés
                </button>
            
                <button class="AjoutSlot2 bouton-important">
                    Ajouter des slots 
                </button>
            </div>
    </div>

  </body>
</html>