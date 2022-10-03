<?php
class Calendar {

  private $pdo = null;
  private $stmt = null;
  public $error = "";
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (Exception $ex) { exit($ex->getMessage()); }
  }

  function __destruct () {
    if ($this->stmt!==null) { $this->stmt = null; }
    if ($this->pdo!==null) { $this->pdo = null; }
  }

  function exec ($sql, $data=null) {
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($data);
      return true;
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
  }

  function save ($start, $end, $txt, $color, $organizers, $id=null) {
    $uStart = strtotime($start);
    $uEnd = strtotime($end);
    if ($uEnd < $uStart) {
      $this->error = "End date cannot be earlier than start date";
      return false;
    }

    if ($id==null) {
      $sql = "INSERT INTO events (start, end, text, color, organizers) VALUES (?,?,?,?,?)";
      $data = [$start, $end, $txt, $color, $organizers];
    } else {
      $sql = "UPDATE events SET start=?, end=?, text=?, color=?, organizers=? WHERE id=?";
      $data = [$start, $end, $txt, $color, $organizers, $id];
    }

    return $this->exec($sql, $data);
  }

  function del ($id) {
    return $this->exec("DELETE FROM events WHERE id=?", [$id]);
  }

  function get ($month, $year) {
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dayFirst = "{$year}-{$month}-01 00:00:00";
    $dayLast = "{$year}-{$month}-{$daysInMonth} 23:59:59";

    if (!$this->exec(
      "SELECT * FROM events WHERE (
        (start BETWEEN ? AND ?)
        OR (end BETWEEN ? AND ?)
        OR (start <= ? AND end >= ?)
      )", [$dayFirst, $dayLast, $dayFirst, $dayLast, $dayFirst, $dayLast]
    )) { return false; }

    $events = ["e" => [], "d" => []];
    while ($row = $this->stmt->fetch()) {
      $eStartMonth = substr($row["start"], 5, 2);
      $eEndMonth = substr($row["end"], 5, 2);
      $eStartDay = $eStartMonth==$month
                 ? (int)substr($row["start"], 8, 2) : 1 ;
      $eEndDay = $eEndMonth==$month
               ? (int)substr($row["end"], 8, 2) : $daysInMonth ;
      for ($d=$eStartDay; $d<=$eEndDay; $d++) {
        if (!isset($events["d"][$d])) { $events["d"][$d] = []; }
        $events["d"][$d][] = $row["id"];
      }
      $events["e"][$row["id"]] = $row;
      $events["e"][$row["id"]]["first"] = $eStartDay;
    }
    return $events;
  }
}

define("DB_HOST", "localhost");
define("DB_NAME", "saith");
define("DB_CHARSET", "utf8");
define("DB_USER", "root");
define("DB_PASSWORD", "");

$_CAL = new Calendar();
