<!doctype html>

<html lang="fr">
<head>
  <meta charset="utf-8">

  <title>Mes données BetterSet</title>

  <link rel="stylesheet" href="../faq.css">
  <link rel="stylesheet" href="donnees.css">
  <link rel="stylesheet" href="../espace-admin/espace-admin.css">
  <script src="donnees.js"></script>
  <script src="../tools.js"></script>
</head>
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../espace-membre/connexion.php');
  exit();
}
include('../nav-from-parent/nav.php');
include('../database/config.php');
include('../database/tools.php');
include('../espace-' . $_SESSION['role'] . '/sidebar.php');
?>

<body>

    <div class="main-content Page">

        <div class="top">

            <div class="Identité">
                <p class="Nom">
                    Nom/Prénom Employé
                </p>
                <!--Vérifier le genre de la personne, afficher l'icone correspondante-->
                <img class="genre" src="../images/female_icon.png" alt="Femme">
                <p class="Sub-info">
                    Age
                </p>
            </div>

            <div class="Account-buttons">
                <button class="Modify-Account">
                    Modifier le compte
                </button>
                <button class="Delete-Account">
                    Supprimer le compte
                </button>
            </div>
          </div>

        <div class="Data-header">
            <h2 class="Data-title">
                Données du BetterSet
            </h2>
            <div class="Duration-buttons">
                <button class="Duration-button Left-Button">Jour</button>
                <button class="Duration-button">Semaine</button>
                <button class="Duration-button">Mois</button>
                <button class="Duration-button Right-Button">Année</button>
            </div>

            <div class="Calendar">
                <img class="Calendar-image" src="../images/calendrier.png" alt="calendrier">
            </div>
        </div>


        <div class="Data">

            <!--Fréquence Cardiaque-->
            <div class="Data-section">
                <h2 class="Section-title">
                Fréquence cardiaque (BPM)
                </h2>
                <!-- <img src="images/information.png" alt="[Info]" class="image-info"> -->
                <div class="chartBox">
                  <canvas id="myChart"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                  <script>

                    // Fréquence Cardiaque
                    const data = {
                      labels: ['8 heures', '10 heures', 'Midi', '14 heures', '16 heures', '18 heures'],
                        datasets: [{
                          label: 'Fréquence Cardiaque',
                          data: [70, 94, 75, 86, 105, 85],
                          borderWidth: 4
                        }]
                    };

                    const config = {
                      type: 'line',
                      data,
                      options: {
                        scales: {
                          y: {
                            suggestedMin: 60,
                            suggestedMax: 120
                          }
                        }
                      }
                    };

                    const myChart = new Chart(
                      document.getElementById('myChart'),
                      config
                    );

                  </script>
            </div>


            <!--Détecteur de sueur-->
            <div class="Data-section">
                <h2 class="Section-title">
                Résultats des capteurs de sueur
                </h2>
                <!-- <img src="images/information.png" alt="[Info]" class="image-info"> -->
                <div class="chartBox">
                  <canvas id="sueurChart"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <script>


                    const sueurdata = {
                      labels: ['8 heures', '10 heures', 'Midi', '14 heures', '16 heures', '18 heures'],
                        datasets: [{
                          label: 'Eau estimée perdue (Litre)',
                          data: [0.2, 0.6, 0.5, 0.7, 0.5, 0.3],
                          borderWidth: 4
                        }]
                    };

                    const sueurconfig = {
                      type: 'bar',
                      data : sueurdata,
                      responsive: true,
                      options: {
                        scales: {
                          y: {
                            suggestedMin: 0,
                            suggestedMax: 1
                          }
                        }
                      }
                    };

                    const sueurChart = new Chart(
                      document.getElementById('sueurChart'),
                      sueurconfig
                    );

                  </script>

            </div>


            <!--Détecteur de gaz-->
            <div class="Data-section">
                <h2 class="Section-title">
                Résultats du capteur de monoxyde de carbone
                </h2>
                <!-- <img src="images/information.png" alt="[Info]" class="image-info"> -->
                <div class="chartBox">
                  <canvas id="gazChart"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <script>

                    const gazdata = {
                      labels: ['8 heures', '10 heures', 'Midi', '14 heures', '16 heures', '18 heures'],
                        datasets: [{
                          label: 'Monoxyde de Carbone (PPM)',
                          data: [40, 130, 200, 110, 50, 30],
                          borderWidth: 4
                        }]
                    };

                    const gazconfig = {
                      type: 'line',
                      data : gazdata,
                      options: {
                        scales: {
                          y: {
                            suggestedMin: 30,
                            suggestedMax: 230
                          }
                        }
                      }
                    };

                    const gazChart = new Chart(
                      document.getElementById('gazChart'),
                      gazconfig
                    );

                  </script>

            </div>

            <!--Sonomètre-->
            <div class="Data-section">
                <h2 class="Section-title">
                Résultats des sonomètres
                </h2> 
                <!-- <img src="images/information.png" alt="[Info]" class="image-info"> -->
                <div class="chartBox">
                  <canvas id="sonChart"></canvas>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                  <script>


                    const sondata = {
                      labels: ['8 heures', '10 heures', 'Midi', '14 heures', '16 heures', '18 heures'],
                        datasets: [{
                          label: 'Décibel sonore (dB)',
                          data: [50, 75, 85, 80, 135, 65],
                          borderWidth: 4
                        }]
                    };

                    const sonconfig = {
                      type: 'line',
                      data : sondata,
                      options: {
                        scales: {
                          y: {
                            suggestedMin: 30,
                            suggestedMax: 130
                          }
                        }
                      }
                    };

                    const sonChart = new Chart(
                      document.getElementById('sonChart'),
                      sonconfig
                    );

                  </script>

            </div>
        </div>
    </div>
<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
<?php
make_footer(false);
?>
</div>
</body>

<script>
addEvent("Duration-button", buttonClick)
addEvent("Modify-Account", modifyAccount)
addEvent("Delete-Account", deleteAccount)
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../chart.js"></script>
