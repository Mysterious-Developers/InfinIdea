<?php
set_include_path('/var/www/blog');
if(session_status() == PHP_SESSION_NONE)
    session_start(); // On démarre la session AVANT toute chose
require_once 'account/autoconnect.php';
require_once 'tools/tools.php';

$db = getDB();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfinIdea : Bienvenue</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/article.css">
    <script src="backend/js/fontawesome.js"></script>
</head>
<body>
    <section class="top-page">
        <header>
            <nav class="top-nav">
                <img src="images/logo.png" alt="MysteriousDevelopers creation" class="logo-top">
                <ul class="main-list">
                    <li class="first-child"><a href="index.html"><p>Accueil &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                    <li class="first-child"><a href=""><p>Recommendations &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                    <li class="first-child"><a href=""><p>Lus récemmment &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                    <li class="first-child"><a href=""><p>A propos &nbsp;<i class="fa-solid fa-angle-down"></i></p></a></li>
                </ul>
            </nav>
            <nav class="user-connection-interaction-nav">
                <ul class="user-connection-interaction-list">
                    <li class="user-menu">
                        <a href="">
                            <p>Bonjour, &nbsp;<p class="unconnected">connectez-vous &nbsp;<i class="fa-solid fa-angle-down"></i></p></p>
                            <ul class="user-connection-scrolling-menu">
                                <li><a href=""><p>Mon compte</p></a></li>
                                <li><a href=""><p>Comment se connecter ?</p></a></li>
                                <li><a href=""><p>A propos</p></a></li>
                                <li><a href=""><p>Mes projets</p></a></li>
                                <li><a href=""><p>Conditions d'utilisations</p></a></li>
                                <li><a href=""><p>Paramètres</p></a></li>
                            </ul>
                        </a>                       
                    </li>  
                    <a href="" class="sign-in unconnected"><li class="sign-in-sub-element"><p>S'inscrire</p></li></a>
                </ul>
            </nav>
        </header>
    </section>

    <?php
        if(!isset($_GET['id']))
        {
            echo '<p style="color:red;">Cet article n\'existe pas</p>';
            die();
        }
        else
        {
            $aid = htmlspecialchars($db, $_GET['id']);
            $sql = 'SELECT * FROM articles WHERE id = ' . $aid;
            $result = mysqli_query($db, $sql);
            if(mysqli_num_rows($result) == 0)
            {
                echo '<p style="color:red;">Cet article n\'existe pas</p>';
                die();
            }
            else
            {
                $row = mysqli_fetch_assoc($result);
                $title = $row['title'];
                $desc = $row['description'];
                $content = $row['content'];
                $author = getPseudo(['creator']);
                $date = correctTimestamp($row['created']);
                $tags = $row['tags'];
                $views = $row['views'];
                $likes = $row['likes'];
                $blocked = $row['blocked'];
                $visibility = $row['visibility'];


            }
        }
    ?>

    <section class="contents-page">
        <div class="article-container">
            <div class="article">
                <div class="img-nav">
                    <div class="displayed-img">
                        <img src="images/base.jpg" alt="" id="displayed-img">
                    </div>
                    <nav class="nav">
                        <ul class="preview-container">
                            <li class="li-img"><button class="li-img"><img src="images/base.jpg" alt="" class="preview"></button></li>
                            <li class="li-img"><button class="li-img"><img src="images/un-carre-long-sur-des-cheveux-fins-lisses.jpeg" alt="" class="preview"></button></li>
                            <li class="li-img"><button class="li-img"><img src="images/logo.png" alt="" class="preview"></button></li>
                        </ul>
                    </nav>
                </div>
                <div class="txt-container">
                    <h3 class="title">Lorem ipsum, dolor sit amet consectetur adipisicing.</h3>
                    <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis ad iusto deserunt voluptates architecto inventore nisi cupiditate praesentium voluptas nam maiores dignissimos, expedita quo optio ratione, recusandae corporis soluta dicta minima libero sunt sint? Fuga illum tenetur sed, dolorem obcaecati earum quos ducimus reprehenderit magni quisquam fugiat id! Nesciunt autem recusandae laboriosam. Minima sint nulla, accusamus maiores inventore quaerat! Soluta eaque provident dolore officiis quibusdam voluptates architecto expedita hic pariatur, alias quisquam facere dignissimos consequuntur omnis, rem inventore. Eius, quas!</p>
                    <div class="interaction-nav">
                        <nav class="nav">
                            <ul class="interaction-container">
                                <li><button><i class="fa-regular fa-user interaction"></i></button></li>
                                <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                                <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                            </ul>
                        </nav>
                    </div> 
                </div>             
            </div>
        </div>

        <div class="comment-section">
            <button><i class="fa-solid fa-xmark close"></i></button>
            <nav>
                <ul>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                    <li class="comment">
                        <h6 class="username">LeBGThéo</h6>
                        <p class="comment-content">Super article, j'adore(ps c théo le dieu) Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui tempore dolorem iste voluptas minima recusandae perspiciatis commodi, similique accusantium magni.</p>
                        <ul class="comment-user-interaction">
                            <li><button><i class="fa-regular fa-heart interaction like"></i></button></li>
                            <li><button><i class="fa-regular fa-comment interaction"></i></button></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </section>

    <section class="bottom-page">
        <footer>
            <div class="site-nav">
                <nav>
                    <ul>
                        <li><p class="nav-title">Soutien</p></li>
                        <li><a href=""><p>Nous contacter</p></a></li>
                        <li><a href=""><p>A propos</p></a></li> 
                    </ul>
                </nav>
                <nav>
                    <ul>
                        <li><p class="nav-title">Contactez-nous</p></li>
                        <li><a href=""><p>Discord</p></a></li>
                        <li><a href=""><p>Mail</p></a></li>
                        <li><a href=""><p>Instagram</p></a></li>
                    </ul>
                </nav>
                <nav>
                    <ul>
                        <li><p class="nav-title">Rejoignez-nous</p></li>
                        <li><a href=""><p>veagle.fr</p></a></li>
                        <li><a href=""><p>Discord</p></a></li>
                        <li><a href=""><p>Instagram</p></a></li>
                    </ul>
                </nav>
            </div>
            <div class="copyright-infos-nav">
                <nav>
                    <ul>
                        <li><p>© 2022 InfinIdea, by VEagle</p></li>
                        <li><a href="">Politique de confidentialité</a></li>
                    </ul>
                </nav>
                <nav class="social-media">
                    <ul>
                        <li><a href="https://discord.gg/Vahr76XmpU" target="_blank"><i class="fa-brands fa-discord"></i></a></li>
                        <li><a href="https://www.instagram.com/nicolas_fsn_/"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a href="https://github.com/Mysterious-Developers"><i class="fa-brands fa-github"></i></a></li>
                        <li><a href="https://mysteriousdev.fr" target="_blank"><i class="fa-solid fa-window-restore"></i></a></li>
                    </ul>
                </nav>
            </div>
        </footer>
    </section>

    <script src="backend/js/img-explorer.js"></script>
    <script src="backend/js/article-interaction.js"></script>
</body>
</html>