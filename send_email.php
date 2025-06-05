<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// 1. Désactive complètement les sorties
ob_start();

// 2. Traitement silencieux
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid method');
    }

    $name = strip_tags(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject'] ?? ''));
    $message = strip_tags(trim($_POST['message'] ?? ''));
    // Configuration email
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kamungujul@gmail.com'; //la personne qui envoie le mail
    $mail->Password = 'cshg emcc rsqd rflx';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($email, $name);
    $mail->addAddress('kamungujul@gmail.com'); //la personne a qui on envoie
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();

    $mail1 = new PHPMailer(true);
    $mail1->isSMTP();
    $mail1->Host = 'smtp.gmail.com';
    $mail1->SMTPAuth = true;
    $mail1->Username = 'kamungujul@gmail.com'; //la personne qui envoie le mail
    $mail1->Password = 'cshg emcc rsqd rflx';
    $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail1->Port = 587;
    $mail1->setFrom('kamungujul@gmail.com');
    $mail1->addAddress($email);
    $mail1->Subject = ('Confirmation de reception');
    $mail1->Body = ('Message bien reçu! Je vous recontacte bientôt');
    $mail1->send();

    // Enregistrement du succès
    file_put_contents('mail_log.txt', date('[Y-m-d H:i:s]')." Mail sent\n", FILE_APPEND);

} catch (Exception $e) {
    // Enregistrement de l'erreur
    file_put_contents('mail_log.txt', date('[Y-m-d H:i:s]')." ERROR: ".$e->getMessage()."\n", FILE_APPEND);
}


//connexion a la base
$host = 'localhost';
$dbname = 'contact';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}


//insertion des données dans la base des données 
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

ob_end_clean();
header("HTTP/1.1 204 No Content");
exit;
?>