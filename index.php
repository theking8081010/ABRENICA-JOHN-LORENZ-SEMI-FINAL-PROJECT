<?php
// ============================================
// VIEW ALL TASKS + ADD TASK FORM
// ============================================
require_once "db.php";

// Get all tasks (latest first)
$stmt = $pdo->query("SELECT * FROM tasks ORDER BY due_date IS NULL, due_date ASC, id DESC");
$tasks = $stmt->fetchAll();

// Random background image — mo-usab sa matag refresh
$bg_url = "https://picsum.photos/seed/" . mt_rand(100000, 999999) . "/1920/1080";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('<?php echo $bg_url; ?>');">
    <div class="container">
        <h1>📝 Task Manager</h1>

        <!-- ADD TASK FORM -->
        <div class="card">
            <h2>Add New Task</h2>
            <form action="add_task.php" method="POST">
                <label>Task Name *</label>
                <input type="text" name="task_name" required maxlength="150" placeholder="e.g. Human sa bayay">

                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Detalye sa task (optional)"></textarea>

                <label>Due Date</label>
                <input type="date" name="due_date">

                <button type="submit" class="btn-add">+ Add Task</button>
            </form>
        </div>

        <!-- TASK LIST -->
        <div class="card">
            <h2>My Tasks (<?php echo count($tasks); ?>)</h2>

            <?php if (empty($tasks)): ?>
                <p class="empty">Wala pa kay task bai. Mag-add na! 🎉</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                            <tr class="<?php echo strtolower($task['status']); ?>">
                                <td><?php echo $task['id']; ?></td>
                                <td><?php echo htmlspecialchars($task['task_name']); ?></td>
                                <td><?php echo htmlspecialchars($task['description']); ?></td>
                                <td>
                                    <span class="badge <?php echo strtolower($task['status']); ?>">
                                        <?php echo $task['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo $task['due_date'] ?: '-'; ?></td>
                                <td class="actions">
                                    <a href="update_status.php?id=<?php echo $task['id']; ?>&status=<?php echo $task['status'] === 'Pending' ? 'Completed' : 'Pending'; ?>"
                                       class="btn-toggle" title="Toggle status">
                                        <?php echo $task['status'] === 'Pending' ? '✔ Mark Done' : '↺ Undo'; ?>
                                    </a>
                                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn-edit">✏ Edit</a>
                                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn-delete"
                                       onclick="return confirm('Sure ka bai? I-delete ni nga task?');">🗑 Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>