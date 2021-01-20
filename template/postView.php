<?php
require '../../model/Database.php';
require '../../model/PostManager.php';
require '../../model/CommentManager.php';

use App\model\Manager\PostManager;
use App\model\Manager\CommentManager;
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
    $post = new PostManager();
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

    <h2>Commentaires</h2>
    <h3>Ajouter un commentaire</h3>
    <form action="commentaires_post.php" method="post">
        <input type="text" name="authot" ><br>
        <textarea name="message"></textarea><br>
        <button type="submit" value="Submit">Submit</button>
    </form>
    <?php
    $comment = new CommentManager();
    $comments = $comment->getCommentsFromPost(1);
    while($comment = $comments->fetch())
    {   
        if ($comment['validation_status'] == 1) {
    ?>
    <div>
        <p>
            <?= htmlspecialchars($comment['author']);?> :
            ( <?= htmlspecialchars($comment['dayMonthYear']);?>
            at <?= htmlspecialchars($comment['hour'] )?> ) <br>
            <?= htmlspecialchars($comment['content']);?>
        </p>
    </div>
    <br>
    <?php
        }
    }
    $comments->closeCursor();
    ?>
    <a href="../../index.php">Retour à l'accueil</a>
</div>
</body>
</html>