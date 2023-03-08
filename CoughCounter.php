<html>
    <head>
        <title> Submission Complete</title>
        <link rel="stylesheet" href="/CC/CoughCounter.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            
    </head>
        <body>


<?php

    require_once 'login.php';

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind paramaters
        $stmt = $conn->prepare("INSERT INTO coughLog (count, gag, retch, notes, date)
        Values (:count, :gag, :retch, :notes, :date)");
            $stmt->bindParam(':count', $count);
            $stmt->bindParam(':gag', $gag);
            $stmt->bindParam(':retch', $retch);
            $stmt->bindParam(':notes', $notes);
            $stmt->bindParam(':date', $date);
        
        //insert a row
        $count = $_POST['count'];
        $gag = isset($_POST['gag']) ? '1' : '0';
        //var_dump($_POST['gag']);
        $retch = isset($_POST['gag']) ? '1' : '0';
        $notes = $_POST['notes'];
        $date = date('Y-m-d H:i:s');
        $stmt->execute();
        $cdate = date('h:i:s a m/d/Y', strtotime($date));
    }

    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
?>
    <center>
    <div class="w3-section w3-border w3-center h3">
        <?php 
            echo "Coughs: "."$count"."<br>"."<br>";
            ?>
        <?php 
            echo "Retched: "."$retch"."<br>"."<br>";  
            ?>  
        <?php 
            echo "Gagged: "."$gag"."<br>"."<br>";     
            ?>  
        <?php 
            echo "Details: "."<br>"."$notes"."<br>"."<br>";
            ?>
        <?php 
            echo "Time: "."$cdate"."<br>"."<br>";
            ?>
    </div>
    </center>
   
    <?php
        $stmt2 = $conn->prepare("select count(*) from coughLog where date WHERE date >= CURDATE()");
        $result = mysql_query($stmt2);
        while ($row = mysql_fetch_assoc($result)) {
            echo $row['firstname'];
            echo $row['lastname'];
            echo $row['address'];
            echo $row['age'];
        }
        
        

        $conn = null;
        ?>


 </body>
</html>


