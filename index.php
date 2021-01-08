<?php
//On inclut le fichier dont on a besoin (ici à la racine de notre site)
require 'model/Database.php';
require 'model/Post.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Projet 5 - Blog</title>
</head>

<body>
    <nav>
        <a href="/">Home</a>
        <a href="view/template/postView.php?id=1">Post</a>
    </nav>
    <div>
        <h1>Lorem ipsum</h1>
        <p>Lorem ipsum</p>

    </div>
</body>
</html>