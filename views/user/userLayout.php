
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="<?php echo BASE_URL?>views/static/userStyle.css">
    <title>Document</title>
</head>
<body>



    <button class="menu-toggle" onclick="toggleMenu()">☰</button>

    <div class="container">
        
         <div class="side-nav" id="sideNav">

             <?php require_once("./views/components/userNavBar.php")?>
       
        </div>

        <?php require_once("./views/user/$fileName" . ".php")?>

    <div>

    <script src="<?php echo BASE_URL?>views/static/userScript.js"></script>
    
</body>
</html>


