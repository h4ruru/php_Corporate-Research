<?php
require_once 'db.php';
require_once 'functions.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $conn->real_escape_string($_GET['delete_id']);
    if (delete_company($conn, $delete_id)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $edit_id = $conn->real_escape_string($_POST['edit_id']);
    $name = $conn->real_escape_string($_POST["name"]);
    $industry = $conn->real_escape_string($_POST["industry"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $website = $conn->real_escape_string($_POST["website"]);
    $contact_email = $conn->real_escape_string($_POST["contact_email"]);

    if (update_company($conn, $edit_id, $name, $industry, $description, $website, $contact_email)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['edit_id'])) {
    $name = $conn->real_escape_string($_POST["name"]);
    $industry = $conn->real_escape_string($_POST["industry"]);
    $description = $conn->real_escape_string($_POST["description"]);
    $website = $conn->real_escape_string($_POST["website"]);
    $contact_email = $conn->real_escape_string($_POST["contact_email"]);

    if (add_company($conn, $name, $industry, $description, $website, $contact_email)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

$result = get_companies($conn);
$edit_row = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    $edit_row = get_company_by_id($conn, $edit_id);
}
?>

<?php require_once 'header.php'; ?>

<?php if ($edit_row): ?>
    <h2>企業情報を編集</h2>
    <form class="edit-form" method="POST" action="">
        <input type="hidden" name="edit_id" value="<?= $edit_row['id'] ?>">
        <label for="name">企業名:</label><br>
        <input type="text" id="name" name="name" value="<?= $edit_row['name'] ?>" required><br><br>
        <label for="industry">業界:</label><br>
        <input type="text" id="industry" name="industry" value="<?= $edit_row['industry'] ?>" required><br><br>
        <label for="description">概要:</label><br>
        <textarea id="description" name="description" required><?= $edit_row['description'] ?></textarea><br><br>
        <label for="website">ウェブサイト:</label><br>
        <input type="url" id="website" name="website" value="<?= $edit_row['website'] ?>"><br><br>
        <label for="contact_email">連絡先メールアドレス:</label><br>
        <input type="email" id="contact_email" name="contact_email" value="<?= $edit_row['contact_email'] ?>"><br><br>
        <input type="submit" value="更新">
    </form>
    <a href="index.php">新規企業情報の追加</a>
<?php else: ?>
    <h2>新規企業情報を追加</h2>
    <form method="POST" action="">
        <label for="name">企業名:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="industry">業界:</label><br>
        <input type="text" id="industry" name="industry" required><br><br>
        <label for="description">概要:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>
        <label for="website">ウェブサイト:</label><br>
        <input type="url" id="website" name="website"><br><br>
        <label for="contact_email">連絡先メールアドレス:</label><br>
        <input type="email" id="contact_email" name="contact_email"><br><br>
        <input type="submit" value="追加">
    </form>
<?php endif; ?>

<h2>登録済み企業</h2>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='company'>";
        echo "<h3>" . $row["name"] . "</h3>";
        echo "<p><strong>業界:</strong> " . $row["industry"] . "</p>";
        echo "<p><strong>概要:</strong> " . $row["description"] . "</p>";
        echo "<p><strong>ウェブサイト:</strong> <a href='" . $row["website"] . "'>" . $row["website"] . "</a></p>";
        echo "<p><strong>連絡先メールアドレス:</strong> " . $row["contact_email"] . "</p>";
        echo "<a href='?edit_id=" . $row["id"] . "'>編集</a> | <a href='?delete_id=" . $row["id"] . "' onclick='return confirm(\"本当に削除しますか？\");'>削除</a>";
        echo "</div>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<?php require_once 'footer.php'; ?>