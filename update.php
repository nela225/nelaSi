<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $ime = trim($_POST['ime'] ?? '');
    $prezime = trim($_POST['prezime'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validacija
    $errors = [];
    if ($id <= 0) $errors[] = 'Neispravan ID.';
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
        // Provjera duplikata emaila (osim za trenutnog korisnika)
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $checkStmt->execute([$email, $id]);
        if ($checkStmt->fetch()) {
            echo json_encode(['success' => false, 'errors' => ['Email već koristi drugi korisnik.']]);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE users SET ime = ?, prezime = ?, email = ? WHERE id = ?");
        $stmt->execute([$ime, $prezime, $email, $id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Korisnik uspješno ažuriran!']);
        } else {
            echo json_encode(['success' => false, 'errors' => ['Korisnik nije pronađen.']]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'errors' => ['Greška pri ažuriranju: ' . $e->getMessage()]]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['Neispravan zahtjev.']]);
}
?>
