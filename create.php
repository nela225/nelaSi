<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime'] ?? '');
    $prezime = trim($_POST['prezime'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validacija
    $errors = [];
    if (empty($ime)) $errors[] = 'Ime je obavezno.';
    if (empty($prezime)) $errors[] = 'Prezime je obavezno.';
    if (empty($email)) {
        $errors[] = 'Email je obavezan.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email format nije ispravan.';
    }

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        // Provjera duplikata emaila
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->fetch()) {
            echo json_encode(['success' => false, 'errors' => ['Email već postoji u bazi.']]);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO users (ime, prezime, email) VALUES (?, ?, ?)");
        $stmt->execute([$ime, $prezime, $email]);
        echo json_encode(['success' => true, 'message' => 'Korisnik uspješno dodan!', 'id' => $pdo->lastInsertId()]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'errors' => ['Greška pri dodavanju: ' . $e->getMessage()]]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['Neispravan zahtjev.']]);
}
?>
