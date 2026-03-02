<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'errors' => ['Neispravan ID.']]);
        exit;
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Korisnik uspješno obrisan!']);
        } else {
            echo json_encode(['success' => false, 'errors' => ['Korisnik nije pronađen.']]);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'errors' => ['Greška pri brisanju: ' . $e->getMessage()]]);
    }
} else {
    echo json_encode(['success' => false, 'errors' => ['Neispravan zahtjev.']]);
}
?>
