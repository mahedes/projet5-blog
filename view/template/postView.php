<?php
//On inclut le fichier dont on a besoin (ici à la racine de notre site)
require '../../model/Database.php';
//Ne pas oublier d'ajouter le fichier Article.php
require '../../model/Post.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mon blog</title>
</head>

<body>
<div>
    <h1>Page Post</h1>
    <?php
    $post = new Post();
    $posts = $post->getPosts();
    while($post = $posts->fetch())
    {
    ?>
    <div>
        <h2>Title : <?= htmlspecialchars($post['title']);?></h2>
        <p><strong>Chapo :</strong> <?= htmlspecialchars($post['chapo']);?></p>
        <p><strong>Content :</strong> <?= htmlspecialchars($post['content']);?></p>
        <p><strong>Author :</strong><?= htmlspecialchars($post['author']);?></p>
        <p><strong>Date of the last update :</strong> <?= htmlspecialchars($post['last_edit']);?></p>
    </div>
    <br>
    <?php
    }
    $posts->closeCursor();
    ?>
    <a href="index.php">Retour à l'accueil</a>
</div>
</body>
</html>