<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

ob_start();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid method');
    }

    $name = strip_tags(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject'] ?? ''));
    $message = strip_tags(trim($_POST['message'] ?? ''));

    // Connexion à la base de données locale
    $dsn = 'mysql:host=localhost;dbname=contact';
    $dbUser = 'root';
    $dbPass = ''; // Mot de passe de ta base locale (ex: MAMP/WAMP)

    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Insertion dans la base
    $stmt = $pdo->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $subject, $message]);

    // Envoi du mail au destinataire
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'kamungujul@gmail.com';
    $mail->Password = 'cshg emcc rsqd rflx';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->setFrom($email, $name);
    $mail->addAddress('kamungujul@gmail.com');
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();

    // Envoi d’un mail de confirmation
    $mail1 = new PHPMailer(true);
    $mail1->isSMTP();
    $mail1->Host = 'smtp.gmail.com';
    $mail1->SMTPAuth = true;
    $mail1->Username = 'kamungujul@gmail.com';
    $mail1->Password = 'cshg emcc rsqd rflx';
    $mail1->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail1->Port = 587;
    $mail1->setFrom('kamungujul@gmail.com');
    $mail1->addAddress($email);
    $mail1->Subject = 'Confirmation de réception';
    $mail1->Body = 'Message bien reçu ! Je vous recontacte bientôt.';
    $mail1->send();

    file_put_contents('mail_log.txt', date('[Y-m-d H:i:s]') . " Mail sent and data saved\n", FILE_APPEND);

} catch (Exception $e) {
    file_put_contents('mail_log.txt', date('[Y-m-d H:i:s]') . " ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
}

ob_end_clean();
header("HTTP/1.1 204 No Content");
exit;
?>
