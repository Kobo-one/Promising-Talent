<?php
session_start();
$_SESSION["company_id"] = 1;
include_once("lib/classes/Activity.class.php");
include_once("lib/classes/Functions.class.php");

if( !empty($_POST) ){
    echo "posted";
    if(isset($_POST['submit'])){
        echo "submitted";
    //if image is chosen
        
            $activity = new Activity();
            $activity->setTitle($_POST['title']);
            $activity->setDescription($_POST['description']);
            $activity->setCompanyId($_SESSION['company_id']);
            $activity->setUserCount($_POST['user_count']);
            $activity->setDates($_POST['dates']);

            if($activity->createActivity()){
                //header("Location: index.php"); 
                echo "send";
            }
        }
        
    }
      


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Promising Talent - Nieuwe activiteit</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="lib/js/script.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,800,700,900' rel='stylesheet' type='text/css'>
</head>
<body>
<?php include_once("includes/nav.inc.php");?>
    <div class="board">
        <div class="top_page"><h1 class="title">Maak een nieuwe activiteit aan en spot talent</h1></div>
        
        <div class="dashboard">
        <form action="" method="post" enctype="multipart/form-data" id="uploadForm">
            <section class="artikel artikel_details">
                  
                <p>Informatie over het artikel dat u wilt verkopen.</p>
                <div class="field">
                    <div class="input_label">
                        <label for="title">Title</label>
                        <input type="text" class="name" id="title" name="title">
                    </div>
                    <div class="input_label">
                        <label for="description">Description</label>
                        <textarea class="name" id="description" name="description">
                        </textarea>
                    </div>

                    <div class="input_label">
                        <label for="user_count">Aantal studenten die kunnen meedoen</label>
                        <input type="number" class="user_count" id="user_count" name="user_count">
                    </div>
                </div>
                
            </section>

                    <p id="dateTitle">Voeg de datums toe (meerdere studenten <strong>mogen</strong> op dezelfde datum komen)</p>
                <div class="field dates">
                    <div class="input_label">
                        <label for="dates">Datum student 1: </label>
                        <input id="dates" name="dates[]" type="date" />
                    </div>
                    
                </div>

                
                <div class="field field-extra"></div>
                
            </section>
            
            <input class="button button_send" name="submit" type="submit" value="CREËER ACTIVITEIT">
        
        </form>
        </div>

    </div>




</body>
</html>