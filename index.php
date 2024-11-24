ini_set('display_errors', 1);
error_reporting(E_ALL);

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog des Développeurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- En-tête du site -->
    <header>
        <h1>Bienvenue sur le Blog des Développeurs</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
            </ul>
        </nav>
    </header>

    <!-- Articles récents -->
    <section>
        <h2>Articles récents</h2>
        
        <!-- Exemple d'article avec récupération des données de la base de données -->
        <?php
        // Connexion à la base de données
        include('db.php');
        
        $query = "SELECT * FROM articles ORDER BY date_publication DESC LIMIT 2"; // Récupère les 2 derniers articles
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='article'>";
                echo "<h3>" . $row['titre'] . "</h3>";
                echo "<p>" . substr($row['contenu'], 0, 100) . "...</p>";
                echo "<p><em>Par " . $row['auteur'] . "</em></p>";
                echo "<a href='article.php?id=" . $row['id'] . "'>Lire la suite</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucun article trouvé.</p>";
        }
        ?>
    </section>

    <footer>
        <p>© 2024 Blog des Développeurs</p>
    </footer>

</body>
</html>
<?php
// Connexion à la base de données
include('db.php');

// Récupérer l'ID de l'article à afficher
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM articles WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $article = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $article['titre']; ?> - Blog des Développeurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Blog des Développeurs</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2><?php echo $article['titre']; ?></h2>
        <p><em>Par <?php echo $article['auteur']; ?> | <?php echo $article['date_publication']; ?></em></p>
        <p><?php echo nl2br($article['contenu']); ?></p>
    </section>

    <!-- Section des commentaires -->
    <section>
        <h3>Commentaires</h3>
        <?php
        $commentQuery = "SELECT * FROM commentaires WHERE id_article = $id ORDER BY date_commentaire DESC";
        $commentResult = mysqli_query($conn, $commentQuery);

        if (mysqli_num_rows($commentResult) > 0) {
            while ($comment = mysqli_fetch_assoc($commentResult)) {
                echo "<p><strong>" . $comment['auteur'] . " :</strong> " . $comment['texte'] . "</p>";
            }
        } else {
            echo "<p>Aucun commentaire pour cet article.</p>";
        }
        ?>

        <!-- Formulaire pour ajouter un commentaire -->
        <h4>Ajouter un commentaire</h4>
        <form action="commenter.php" method="POST">
            <textarea name="commentaire" placeholder="Votre commentaire..." required></textarea>
            <input type="hidden" name="article_id" value="<?php echo $id; ?>">
            <input type="text" name="auteur" placeholder="Votre nom" required>
            <button type="submit">Commenter</button>
        </form>
    </section>

    <footer>
        <p>© 2024 Blog des Développeurs</p>
    </footer>

</body>
</html>
<?php
// Connexion à la base de données
include('db.php');

if (isset($_POST['commentaire']) && isset($_POST['article_id']) && isset($_POST['auteur'])) {
    $commentaire = mysqli_real_escape_string($conn, $_POST['commentaire']);
    $article_id = $_POST['article_id'];
    $auteur = mysqli_real_escape_string($conn, $_POST['auteur']);
    
    $query = "INSERT INTO commentaires (texte, auteur, id_article) VALUES ('$commentaire', '$auteur', $article_id)";
    
    if (mysqli_query($conn, $query)) {
        header("Location: article.php?id=" . $article_id); // Redirige vers l'article
    } else {
        echo "Erreur lors de l'ajout du commentaire.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire - Blog des Développeurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Blog des Développeurs</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="connexion.php">Se connecter</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>S'inscrire</h2>
        <form action="inscription_action.php" method="POST">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
    </section>

    <footer>
        <p>© 2024 Blog des Développeurs</p>
    </footer>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - Blog des Développeurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Blog des Développeurs</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Se connecter</h2>
        <form action="connexion_action.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </section>

    <footer>
        <p>© 2024 Blog des Développeurs</p>
    </footer>

</body>
</html>
<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "blog";

$conn =
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - Blog des Développeurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Blog des Développeurs</h1>
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">S'inscrire</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Se connecter</h2>
        <form action="connexion_action.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </section>

    <footer>
        <p>© 2024 Blog des Développeurs</p>
    </footer>

</body>
</html>



<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "blog";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
