<!--traiter  formulaire HTML et  insérer les données  dans une base de données MySQL.-->
<?php
$host = 'localhost';
$dbname = 'contact';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
//langues: une case à cocher multiple.
//on le transforme en chaine séparée par des virgules : Français, Anglais
//implode:transforme le tableau en chaîne séparée par des virgules.
// post: envoyer des données d’un formulaire au serveu
//Récupération des données du formulaire
$nom = $_POST['name'];
$message = $_POST['message'];
$email = $_POST['email'];
$sujet = $_POST['subject'];

//Insertion les donnees dans la base de données
$sql = "INSERT INTO contact (nom, email, sujet, message)
        VALUES (:nom, :email, :sujet, :message)";
//préparer la requête SQL avec les paramètres
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nom' => $nom,
    ':message' => $message,
    ':email' => $email,
    ':sujet' => $sujet,
]);

exit;
?>