<?php 

include_once("lib/classes/Activity.class.php");
include_once("lib/classes/Functions.class.php");

$activities = Activity::getAllActivities();




?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home page</title>
    <link rel="stylesheet" href="css/style2.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,800,700,900' rel='stylesheet' type='text/css'>
    <script src="lib/js/script.js"></script>
</head>
<body class="mobile">


<div class="header">

    <h1>Promising Talent</h1>
    <a href="create_activity.php"><img class="header__img" src="img/nav.png" alt="nav"></a>

</div>

<div class="content">


    <?php
foreach( $activities as $key => $activity ){
    
$student_amount = count($activity["student"]);
echo '<div class="activity">';
echo '<h2>'.$activity["title"].'</h2>';
echo '<div class="activity__imgdiv"';

echo '>';
echo '<img class="activity__img" src="'.$activity["img"].'" alt="'.$activity["title"].'"></div>';
echo '<div class="center">';
echo '<p> '.$student_amount."/". $activity["user_count"].' </p>';
echo '<a class="cta" href="#"';
if($student_amount == $activity["user_count"]){
    echo 'style="background-color: grey; cursor: default"> Volzet';
}
else{
    echo '> Schrijf je in ';
}

echo '</a>';
echo '</div>' ;
echo '</div>';




}
?>
    
    
    


</div>



</body>