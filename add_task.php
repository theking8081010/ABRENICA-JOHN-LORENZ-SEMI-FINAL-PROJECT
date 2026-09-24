<?php
// ============================================
// ADD TASK
// ============================================
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task_name = trim($_POST["task_name"]);
    $description = trim($_POST["description"]);
    $due_date = !empty($_POST["due_date"]) ? $_POST["due_date"] : null;

    if ($task_name === "") {
        die("Task name kay gikinahanglan bai!");
    }

    $stmt = $pdo->prepare(
        "INSERT INTO tasks (task_name, description, status, due_date)
         VALUES (?, ?, 'Pending', ?)"
    );
    $stmt->execute([$task_name, $description, $due_date]);

    header("Location: index.php");
    exit;
}

header("Location: index.php");
exit;