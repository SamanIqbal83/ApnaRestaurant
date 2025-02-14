<?php
session_start();
include('db_connection.php');
if ($_SESSION['role'] !== 'manager') {
    header("Location:login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $task_name = $_POST['task_name'];
    $query = "INSERT INTO tasks (employee_id, task_name, status) VALUES ('$employee_id', '$task_name', 'Pending')";
    mysqli_query($conn, $query);
    echo "<script>alert('Task Assigned!'); window.location.href='assign_task.php';</script>";
}

$employees = mysqli_query($conn, "SELECT id, name FROM users WHERE role='employee'");
?>
<h2>Assign Task</h2>
<form method="POST">
    <select name="employee_id" required>
        <?php while ($emp = mysqli_fetch_assoc($employees)) { ?>
        <option value="<?= $emp['id'] ?>"><?= $emp['name'] ?></option>
        <?php } ?>
    </select>
    <input type="text" name="task_name" placeholder="Task Name" required>
    <button type="submit">Assign</button>
</form>