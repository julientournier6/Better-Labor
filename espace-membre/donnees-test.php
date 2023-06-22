<html>
<body>
<button id="activateLED"  onclick="location.href='?<?php 
$arg = 'id=' . $_GET['id'];
if ( (!isset($_GET['send'])) || ($_GET['send'] == '0') ) {
    $arg = $arg . '&send=1';
}
else {
    $arg = $arg . '&send=0';
}
echo $arg ?>'" class="bouton-important center">
<?php
if (isset($_GET['send'])) {
    if ($_GET['send'] == "1") {
        echo "Désactiver la LED";
    }
    else {
        echo "Activer la LED";
    }
}
else {
    echo "Activer la LED";
}
?>
</button>

<?php
include_once("../database/config.php");
$group = "G06B";

if (isset($_GET['send'])) {
    activateLED();
}

function activateLED() {
    global $group;
    if ($_GET["send"] == "1") {
        $val = "VERT";
    }
    else {
        $val = "RIEN";
    }
    $req = "2";
    $type = "a";
    $num = "01";
    //$trame = "1" . $group . "1201" . $val . "000011";
    $trame = "1" . $group . $req . $type . $num . $val . "000011";
    //echo "Trame envoyée : $trame<br />";
    $ch = curl_init();
    curl_setopt(
    $ch,
    CURLOPT_URL,
    "http://projets-tomcat.isep.fr:8080/appService/?ACTION=COMMAND&TEAM=$group&TRAME=$trame");
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
}
echo "<br /> <br/>";

$ch = curl_init();
curl_setopt(
$ch,
CURLOPT_URL,
"http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=$group");
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$data = curl_exec($ch);
curl_close($ch);

// echo "Raw Data:<br />";
// echo("$data");

$data_tab = str_split($data,33);
$size=count($data_tab);
$day = date("d", strtotime("-1 days"));
$month = date("m");
$year = date("Y");
echo "<strong> Données capteur cardiaque du $day/$month/$year: </strong> <br />  <br />";
$last_values = [];
$last_times = [];

for($i= $size - 2; $i>0; $i--) {
$trame = $data_tab[$i];
$t = substr($trame,0,1);
$o = substr($trame,1,4);

// décodage avec sscanf
list($t, $o, $r, $c, $n, $valeur, $a, $x, $year, $month, $day, $hour, $min, $sec) =
sscanf($trame,"%1s%4s%1s%1s%2s%4s%4s%2s%4s%2s%2s%2s%2s%2s");
//echo("Trame $i : $t,$o,$r,$c,$n,$valeur,$a,$x,$year,$month,$day,$hour,$min,$sec<br />");
    if ($o == $group && $year == date("Y") && $month == date("m") && $day == date("d", strtotime("-1 days"))) {
        $date = new DateTime();

        $date->setDate($year, $month, $day);
        $date->setTime($hour, $min, $sec);

        $date = $date->format('Y-m-d H:i:s');
        if ($c == "9" && $valeur != "0000") {
            $trimmedValue = ltrim($valeur, '0');
            echo("$trimmedValue bpm à $hour:$min:$sec <br />");
            $stmt = $conn->prepare("INSERT INTO mesure (ID_capteur, valeur, DateTime) VALUES(?, ?, ?)");
            $stmt->bind_param('sss', $c, $valeur, $date);
            if ($stmt->execute()) {
                //echo "New record created successfully<br />";
            }
            else {
                //echo "New record creation failed because $stmt->error<br />";
            }
            echo "<br />";
            if (count($last_values) < 5) {
                array_push($last_values, $trimmedValue);
                array_push($last_times, $hour . ":" . $min . ":" . $sec);
            }
        }
    }
}


?>
<p id="last-values" style="display: none;"><?php 
echo (implode(',', $last_values)); 
?></p>
<p id="last-times" style="display: none;"><?php 
echo (implode(',', $last_times));
?></p>
</body>
