<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <title></title>
    <!-- FONT AWESOME ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL?>views/static/adminStyle.css">
    
    
</head>
<body>


    <?php require_once("./views/components/NavBar.php")?>

    <div class="main-content">


    
        <?php require_once("./views/admin/$fileName" . ".php")?>


    </div>




</body>
</html>



