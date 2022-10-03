<?php
if (!isset($_POST["req"])) { exit("INVALID REQUEST"); }
require "calendar.php";
switch ($_POST["req"]) {
  case "draw":
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $_POST["month"], $_POST["year"]);
    $dateFirst = "{$_POST["year"]}-{$_POST["month"]}-01";
    $dateLast = "{$_POST["year"]}-{$_POST["month"]}-{$daysInMonth}";
    $dayFirst = (new DateTime($dateFirst))->format("w");
    $dayLast = (new DateTime($dateLast))->format("w");

    $sunFirst = true;
    $days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    if ($sunFirst) { array_unshift($days, "Sun"); }
    else { $days[] = "Sun"; }
    foreach ($days as $d) { echo "<div class='calsq head'>$d</div>"; }
    unset($days);

    if ($sunFirst) { $pad = $dayFirst; }
    else { $pad = $dayFirst==0 ? 6 : $dayFirst-1 ; }
    for ($i=0; $i<$pad; $i++) { echo "<div class='calsq blank'></div>"; }

    $events = $_CAL->get($_POST["month"], $_POST["year"]);
    $nowMonth = date("n");
    $nowYear = date("Y");
    $nowDay = ($nowMonth==$_POST["month"] && $nowYear==$_POST["year"]) ? date("j") : 0 ;
    for ($day=1; $day<=$daysInMonth; $day++) { ?>
    <div class="calsq day<?=$day==$nowDay?" today":""?>" data-day="<?=$day?>">
      <div class="calnum"><?=$day?></div>
        <?php if (isset($events["d"][$day])) { foreach ($events["d"][$day] as $eid) { ?>
        <div class="calevt" data-eid="<?=$eid?>"
             style="background:<?=$events["e"][$eid]["color"]?>">
          <?=nl2br(htmlentities($events["e"][$eid]["text"] . "\n" . $events["e"][$eid]["organizers"], ENT_QUOTES, 'UTF-8'))?>
        </div>
        <?php if ($day == $events["e"][$eid]["first"]) {
          echo "<div id='evt$eid' class='calninja'>".json_encode($events["e"][$eid])."</div>";
        }}} ?>
    </div>
    <?php }

    if ($sunFirst) { $pad = $dayLast==0 ? 6 : 6-$dayLast ; }
    else { $pad = $dayLast==0 ? 0 : 7-$dayLast ; }
    for ($i=0; $i<$pad; $i++) { echo "<div class='calsq blank'></div>"; }
    break;

  case "save":
    if (!is_numeric($_POST["eid"])) { $_POST["eid"] = null; }
    echo $_CAL->save(
      $_POST["start"], $_POST["end"], $_POST["txt"], $_POST["color"], $_POST["organizers"],
      isset($_POST["eid"]) ? $_POST["eid"] : null
    ) ? "OK" : $_CAL->error ;
    break;

  case "del":
    echo $_CAL->del($_POST["eid"])  ? "OK" : $_CAL->error ;
    break;
}
