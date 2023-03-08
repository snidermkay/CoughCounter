<?php

require_once 'login.php';

echo "<link rel='stylesheet' href='/CC/ccTable.css'>";
echo '<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">';
echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Count</th><th>Gag</th><th>Retch</th><th>Notes</th><th>Date</tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }
    
    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
    }
    
    function beginChildren() {
        echo "<tr>";
    }
    
    function endChildren() {
        echo "</tr>" . "\n";
    }
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$stmt = $conn->prepare("update Persons set age = 56 where age is null");
    //$stmt->execute();
    $stmt = $conn->prepare("SELECT count, gag, retch, notes, date from coughLog");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
    

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
echo "<table>";
echo "<th>Average</th>";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("select avg(count) 'Average Count' from coughLog");
    $stmt->execute();
    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        echo $v;
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
