<?php
// ============================================
// UPDATE STATUS (Pending <-> Completed)
// ============================================
require_once "db.php";

$id = (int) ($_GET["id"] ?? 0);
$status = $_GET["status"] === "Completed" ? "Completed" : "Pending";

if ($id > 0) {
    $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
}

header("Location: index.php");
exit;