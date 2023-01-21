<HTML>
    <head>
        <title>Quiz</title>
        <link rel ="stylesheet" href = "quiz.css"/>
    </head>
<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../espace-membre/connexion.php');
  exit();
}
if ($_SESSION['role'] == 'admin') {
    redirect("espace-admin");
    exit();
}
include('../database/config.php');
include('../database/tools.php');

include('../nav-from-parent/nav.php');
include('../espace-' . $_SESSION['role'] . '/sidebar.php');

?>
<body>    
    <div class="main-content">
        <div class="scoreFinal" id = "scoreFinaltkt">
            <p id = "scoreFinal">   </p>
        </div>
        
        <div class="arrièrePlan">     
            <div class="toutCentrer">  
                <H1 class="quiz-titre">QCM avec cases à cocher</H1>

                <FORM NAME="qcm1">
                    <br>
                    <br> 
                    <div class="carreQuestion" id="Question1">      
                        <B>Question 1 :</B><BR>
                        Le port du casque est-il obligatoire sur un chantier ?<BR>
                        <br>
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix1" VALUE=1 id="Q1ReponseA">Oui</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix1" VALUE=0 id="Q1ReponseB">Non</INPUT>
                    </div> 
                    <BR>
                    <BR>
                    <br>    
                    <div class="carreQuestion" id="Question2">
                        <B>Question 2 :</B><BR>
                        Le casque de better labor permet de détecter :<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix2" VALUE=1 id="Q2ReponseA">Le taux de sueur</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix2" VALUE=0 id="Q2ReponseB">Le poids de la personne</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix2" VALUE=1 id="Q2ReponseC">Son BPM</INPUT>
                    </div>
                    <BR>
                    <BR>
                    <br> 
                    <div class="carreQuestion" id="Question3">
                        <B>Question 3 :</B><BR>
                        Quelle quantité d'eau faut-il boire au minimum par jour ?<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix3" VALUE=0 id="Q3ReponseA">1 litre</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q3ReponseB">20 litres</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q3ReponseC">2 litres</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q3ReponseD">1,5 litre</INPUT>
                    </div>
                    <BR>
                    <BR>
                    <br> 
                    <div class="carreQuestion" id="Question4">
                        <B>Question 4 :</B><BR>
                        Qui organise le chantier ?<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q4ReponseA">L'entrepreneur</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q4ReponseB">Le chef de chantier</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q4ReponseC">Le chien de garde</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q4ReponseD">L'architecte</INPUT>
                    </div>
                    <BR>
                    <BR>    
                    <br> 
                    <div class="carreQuestion" id="Question5">
                        <B>Question 5 :</B><BR>
                        En cas d'incendie sur le chantier que faire ?<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q5ReponseA">Rester sur le chantier</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q5ReponseB">Eteindre les flammes avec un seau d'eau</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q5ReponseC">En profiter pour faire un BBQ</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q5ReponseD">Evacuer</INPUT>
                    </div>
                    <BR>
                    <BR>
                    <br> 
                    <div class="carreQuestion" id="Question6">
                        <B>Question 6 :</B><BR>
                        Quand faut-il se laver les mains ?<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q6ReponseA">1 fois par jour</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q6ReponseB">Avant de manger</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q6ReponseC">Dès que l'on peut</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q6ReponseD">Avant de partir</INPUT>
                    </div>
                    <BR>
                    <BR>
                    <br> 
                    <div class="carreQuestion" id="Question7">
                        <B>Question 7 :</B><BR>
                        Que faut-il faire suite à un accident sur le chantier ?<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q7ReponseA">Avertir le chef de chantier</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=0 id="Q7ReponseB">Rentrer directement chez soi</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q7ReponseC">Ne pas bouger</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q7ReponseD">Aller à l'hopital si la blessure semble/est grave</INPUT>
                    </div>
                    <BR>
                    <BR>
                    <br> 
                    <div class="carreQuestion" id="Question8">
                        <B>Question 8 :</B><BR>
                        A quoi sert la pelleteuse ?<BR>
                        <br> 
                        <B>Réponse(s) :</B>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q8ReponseA">A démolir</INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q8ReponseB">A assainir </INPUT>
                        <BR><INPUT TYPE=CHECKBOX NAME="choix" VALUE=1 id="Q8ReponseC">A déblaier</INPUT>
                    </div>
                    <BR>
                    <br> 
                    <br>
                    <button type="button" class="Valider" id="Resultat">
                        <B>Valider</B>
                        <script src="quiz.js">
                        </script>
                    </button>
                </form>
            </div>
        </div>
    </div>
<!--Les 2 </div> qui suivent servent à fermer les div écrites dans sidebar.php  -->
</div>
<?php
make_footer(false);
?>
</div>
</BODY>
</HTML>


    