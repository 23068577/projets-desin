<?php

// db.php : Connexion à la base de données MySQL

$host = 'localhost'; // Hôte de la base de données

$dbname = 'gestion_reservations'; // Nom de la base de données

$username = 'root'; // Nom d'utilisateur MySQL

$password = ''; // Mot de passe MySQL (vide par défaut pour XAMPP)



try {

    // Connexion à la base de données avec PDO

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Définir le mode d'erreur pour afficher les exceptions

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    // En cas d'erreur de connexion

    echo "Erreur de connexion : " . $e->getMessage();

}

?>

<?php

include('db.php'); // Connexion à la base de données



// Si le formulaire a été soumis

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date_reservation = $_POST['date']; // Récupération de la date et heure soumise



    // Requête pour récupérer les salles disponibles à la date donnée

    $sql = "SELECT * FROM salles WHERE id NOT IN (SELECT salle_id FROM reservations WHERE date_reservation = :date_reservation)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['date_reservation' => $date_reservation]);



    // Récupérer les résultats

    $salles = $stmt->fetchAll();

} else {

    $salles = [];

}

?>



<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Réservation de Salles - Recherche</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="styles.css" rel="stylesheet">

</head>

<body>



<div class="container mt-4">

    <h2>Rechercher une Salle</h2>

    <form action="recherche.php" method="POST">

        <div class="mb-3">

            <label for="date" class="form-label">Date et Heure</label>

            <input type="datetime-local" class="form-control" id="date" name="date" required>

        </div>

        <button type="submit" class="btn btn-primary">Rechercher</button>

    </form>



    <?php if (!empty($salles)): ?>

        <h3 class="mt-4">Salles Disponibles</h3>

        <table class="table mt-3">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Nom de la Salle</th>

                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php foreach ($salles as $salle): ?>

                    <tr>

                        <td><?= $salle['id']; ?></td>

                        <td><?= $salle['nom']; ?></td>

                        <td>

                            <a href="reserver.php?id=<?= $salle['id']; ?>&date=<?= $date_reservation; ?>" class="btn btn-success">Réserver</a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Aucune salle disponible à la date sélectionnée.</p>

    <?php endif; ?>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php

include('db.php'); // Connexion à la base de données



// Vérifier si l'ID de la salle et la date ont été passés dans l'URL

if (isset($_GET['id']) && isset($_GET['date'])) {

    $salle_id = $_GET['id'];

    $date_reservation = $_GET['date'];



    // Vérifier si la salle est déjà réservée à cette date

    $sql = "SELECT * FROM reservations WHERE salle_id = :salle_id AND date_reservation = :date_reservation";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['salle_id' => $salle_id, 'date_reservation' => $date_reservation]);

    $reservationExist = $stmt->fetch();



    if ($reservationExist) {

        echo "<p>La salle est déjà réservée pour cette date.</p>";

    } else {

        // Insérer la réservation dans la base de données

        $sql = "INSERT INTO reservations (salle_id, date_reservation) VALUES (:salle_id, :date_reservation)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute(['salle_id' => $salle_id, 'date_reservation' => $date_reservation]);

        echo "<p>Réservation effectuée avec succès !</p>";

    }

}

?>



<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Réservation de Salle</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>



<div class="container mt-4">

    <h2>Réservation de Salle</h2>

    <p>Vous avez réservé la salle avec succès pour le <strong><?= $_GET['date']; ?></strong>.</p>

    <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php

include('db.php'); // Connexion à la base de données



// Requête pour récupérer toutes les réservations

$sql = "SELECT r.id, s.nom AS salle, r.date_reservation

        FROM reservations r

        JOIN salles s ON r.salle_id = s.id";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$reservations = $stmt->fetchAll();

?>



<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Liste des Réservations</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>



<div class="container mt-4">

    <h2>Liste des Réservations</h2>

    <table class="table">

        <thead>

            <tr>

                <th>ID</th>

                <th>Salle</th>

                <th>Date et Heure</th>

                <th>Actions</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($reservations as $reservation): ?>

                <tr>

                    <td><?= $reservation['id']; ?></td>

                    <td><?= $reservation['salle']; ?></td>

                    <td><?= $reservation['date_reservation']; ?></td>

                    <td>

                        <a href="modifier.php?id=<?= $reservation['id']; ?>" class="btn btn-warning">Modifier</a>

                        <a href="annuler.php?id=<?= $reservation['id']; ?>" class="btn btn-danger">Annuler</a>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
