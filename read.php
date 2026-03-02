<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'config.php';

$search = trim($_GET['search'] ?? '');
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;

try {
    if (!empty($search)) {
        $searchParam = "%$search%";
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE ime LIKE ? OR prezime LIKE ? OR email LIKE ?");
        $countStmt->execute([$searchParam, $searchParam, $searchParam]);
        $total = $countStmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM users WHERE ime LIKE ? OR prezime LIKE ? OR email LIKE ? ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$searchParam, $searchParam, $searchParam, $limit, $offset]);
    } else {
        $countStmt = $pdo->query("SELECT COUNT(*) FROM users");
        $total = $countStmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM users ORDER BY created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$limit, $offset]);
    }

    $users = $stmt->fetchAll();
    $totalPages = ceil($total / $limit);

    echo json_encode([
        'success' => true,
        'users' => $users,
        'total' => $total,
        'page' => $page,
        'totalPages' => $totalPages,
        'limit' => $limit
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'errors' => ['Greška pri čitanju: ' . $e->getMessage()]]);
}
?>
