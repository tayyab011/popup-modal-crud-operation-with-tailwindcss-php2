<?php
$conn = mysqli_connect("localhost","root","","practice2");


function bap($baperbap){
    $baperbap=htmlspecialchars($baperbap);
    $baperbap=trim($baperbap);
    $baperbap=stripcslashes($baperbap);
    return $baperbap ;
}
?>