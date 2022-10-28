<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
{
    session_start(); // On démarre la session AVANT toute chose
}
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';

require_once 'vendor/autoload.php';


$db = getDB();

logs('Commence à écrire');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : Bienvenue</title>
    <link rel="stylesheet" href="../css/header.css">
    <script src="../backend/library/jquery-3.6.1.min.js"></script>
    <script src="../backend/js/paste-image.js"></script>
</head>
<body>
    <section class="top-page">
        <header>
            <nav class="top-nav">
                <img src="../images/logo_veagle_white.png" alt="MysteriousDevelopers creation" class="logo-top">
                <ul class="main-list">
                    <li class="first-child"><a href="#"><p><i class="fa-solid fa-house nav-icon"></i> Accueil</p></a></li>
                    <li class="first-child"><a href="explore.php?type=recommandations"><p><i class="fa-solid fa-shuffle nav-icon"></i> Recommendations</p></a></li>
                    <li class="first-child"><a href="explore.php?type=recents"><p><i class="fa-regular fa-heart nav-icon"></i> Suivis</p></a></li>
                    <li class="first-child"><a href=""><p><i class="fa-solid fa-question nav-icon"></i>Créer</p></a></li>
                </ul>
            </nav>
            <nav class="user-connection-interaction-nav">
                <ul class="user-connection-interaction-list">
                    <li class="user-menu">
                        <a href="account/login.php">
                            <p>Bonjour, &nbsp;

                                <?php
                                if(isset($_SESSION['id'])) // Si l'utilisateur est connecté, on affiche son pseudo
                                {
                                    echo('<p class="unconnected">' . getPseudo($_SESSION['id']) . '<i class="fa-solid fa-angle-down arrow"></i></p>');
                                }
                                else // Sinon on affiche qu'il faut de connecter
                                {
                                    echo('<p class="unconnected">connectez-vous<i class="fa-solid fa-angle-down arrow"></i></p>');
                                }
                                ?>

                            </p>
                            <ul class="user-connection-scrolling-menu">
                                <li><a href="account/account.php"><p>Mon compte</p></a></li>
                                <li><a href=""><p>A propos</p></a></li>
                                <li><a href=""><p>Mes projets</p></a></li>
                                <li><a href="account/account.php"><p>Paramètres</p></a></li>
                                <li><a href="account/logout.php"><p>Déconnexion</p></a></li>
                            </ul>
                        </a>
                    </li>
                    <?php
                    if(!isset($_SESSION['id'])) // Si il n'est pas connecté, on lui propose de se connecter
                    {
                        echo('<a href="account/register.php" class="sign-in unconnected"><li class="sign-in-sub-element"><p>S\'inscrire</p></li></a>');
                    }
                    ?>
                </ul>
        </header>
    </section>
    <?php
        if(!isset($_SESSION['id']))
        {?>
            <p class="unconnected">Vous devez être connecté pour accéder à cette page</p>
            <style>
                .unconnected
                {
                    display: block;
                    margin: auto;
                    text-align: center;
                    font-size: 1.5em;
                    margin-top: 2em;
                }
            </style>
            <?php

        }
        elseif(isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['content']) && isset($_POST['tags']) && $_POST['article'])
        {

            $title = SQLpurify($_POST['title']);
            $desc = SQLpurify($_POST['desc']);
            $content = SQLpurify($_POST['content']);
            $tags = SQLpurify($_POST['tags']);
            $article = SQLpurify($_POST['article']);
            $author = $_SESSION['id'];

            // On modifie les valeurs par défaut avec les nouvelles pour l'article
            $sql = "UPDATE articles
                    SET name = '$title',
                        description = '$desc',
                        content = '$content',
                        tags = '$tags',
                        visibility = 'public'
                    WHERE id = $article
                    AND creator = $author";


            $result = mysqli_query($db, $sql);

            ?>

                <form action="write.php" method="post">
                    <input type="text" name="title" placeholder="Titre" value="<?php echo $title; ?>">
                    <input type="text" name="desc" placeholder="Description" value="<?php echo $desc; ?>">
                    <textarea type="text" name="content" id="content-txt" placeholder="Contenu"><?php echo $content; ?></textarea>
                    <input type="hidden" name="article" id="article-id" value="<?php echo $article; ?>">
                    <!-- add disabled button -->

                    <input type="text" name="tags" placeholder="Tags" value="<?php echo $tags; ?>">
                <input type="submit" value="Envoyer"<?php if($result) echo " disabled"; ?>>
                </form>
            <?php
            if($result) {
                echo '<p style="color: green;">Votre article a bien été publié !</p>';
                echo "<style> .input[type='submit'] { backdrop-filter: green; } </style>";
                logs('Utilisateur publie un article');
            }
            else
            {
                echo '<p style="color: red;">Une erreur est survenue lors de la publication de votre article.</p>';
                echo "<style> .input[type='submit'] { backdrop-filter: red; } </style>";
                logs('Utilisateur a une erreur en publiant un article');
            }
        }
        else {
            $uuid = uniqid();
            $sql = "INSERT INTO articles (uid, creator, visibility) VALUES ('" . $uuid . "', '" . $_SESSION['id'] . "', 'not-written')";
            $result = mysqli_query($db, $sql);
            if (!$result) {
                echo '<p style="color:red;">Erreur lors de la création de l\'article';
            } else {
                $aid = mysqli_insert_id($db);

                ?>

            <form action="write.php" method="post">
                <input type="text" name="title" placeholder="Titre">
                <input type="text" name="desc" placeholder="Description">
                <textarea type="text" name="content" id="content-txt" placeholder="Contenu"></textarea>
                <input type="text" name="tags" placeholder="Tags">
                <input type="hidden" name="article" id="article-id" value="<?php echo $aid; ?>">
                <input type="submit" value="Envoyer">
            </form>
            <?php
            }
        }
        ?>
</body>
</html>