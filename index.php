<?php
//On inclut le fichier dont on a besoin (ici à la racine de notre site)
require 'model/Database.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Projet 5 - Blog</title>
</head>

<body>
    <div>
        <h1>Lorem ipsum</h1>
        <p>Lorem ipsum</p>
        <?php

        $db = new Database();
        echo $db->getConnection();
        ?>
    </div>
</body>
</html>