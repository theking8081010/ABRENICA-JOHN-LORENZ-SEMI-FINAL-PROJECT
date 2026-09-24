<?php
// ============================================
// EDIT TASK
// ============================================
require_once "db.php";

// UPDATE - kung nagsubmit na ug form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int) $_POST["id"];
    $task_name = trim($_POST["task_name"]);
    $description = trim($_POST["description"]);
    $status = $_POST["status"] === "Completed" ? "Completed" : "Pending";
    $due_date = !empty($_POST["due_date"]) ? $_POST["due_date"] : null;

    if ($task_name === "") {
        die("Task name kay gikinahanglan bai!");
    }

    $stmt = $pdo->prepare(
        "UPDATE tasks
         SET task_name = ?, description = ?, status = ?, due_date = ?
         WHERE id = ?"
    );
    $stmt->execute([$task_name, $description, $status, $due_date, $id]);

    header("Location: index.php");
    exit;
}

// DISPLAY FORM - kuhaa ang task gikan sa database
$id = (int) ($_GET["id"] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    die("Task wala makita bai!");
}

// Random background image — mo-usab sa matag refresh
$bg_url = "https://picsum.photos/seed/" . mt_rand(100000, 999999) . "/1920/1080";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('<?php echo $bg_url; ?>');">
    <div class="container">
        <h1>✏ Edit Task</h1>
        <div class="card">
            <form action="edit_task.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

                <label>Task Name *</label>
                <input type="text" name="task_name" required maxlength="150"
                       value="<?php echo htmlspecialchars($task['task_name']); ?>">

                <label>Description</label>
                <textarea name="description" rows="3"><?php echo htmlspecialchars($task['description']); ?></textarea>

                <label>Status</label>
                <select name="status">
                    <option value="Pending" <?php echo $task['status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="Completed" <?php echo $task['status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                </select>

                <label>Due Date</label>
                <input type="date" name="due_date" value="<?php echo $task['due_date']; ?>">

                <div class="btn-group">
                    <button type="submit" class="btn-add">💾 Save Changes</button>
                    <a href="index.php" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>