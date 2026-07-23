<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include('db_connect.php');

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = intval($_SESSION['user_id']);

$check = mysqli_query($conn, "SELECT id FROM tags WHERE user_id = $user_id AND name IN ('Personal','Work')");
if (mysqli_num_rows($check) < 2) {
    $existing = [];
    while ($r = mysqli_fetch_assoc($check)) $existing[] = $r['name'];
    if (!in_array('Personal', $existing))
        mysqli_query($conn, "INSERT INTO tags (user_id, name) VALUES ($user_id, 'Personal')");
    if (!in_array('Work', $existing))
        mysqli_query($conn, "INSERT INTO tags (user_id, name) VALUES ($user_id, 'Work')");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['add_note'])) {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $tag_id = !empty($_POST['tag_id']) ? intval($_POST['tag_id']) : 'NULL';
        if (!empty($title) && !empty($content)) {
            mysqli_query($conn, "INSERT INTO notes (user_id, title, content, tag_id) VALUES ($user_id, '$title', '$content', $tag_id)");
        }
        header("Location: notes.php");
        exit();
    }

    if (isset($_POST['delete_note'])) {
        $note_id = intval($_POST['note_id']);
        mysqli_query($conn, "DELETE FROM notes WHERE id = $note_id AND user_id = $user_id");
        header("Location: notes.php");
        exit();
    }

    if (isset($_POST['edit_note'])) {
        $note_id = intval($_POST['note_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $tag_id = !empty($_POST['tag_id']) ? intval($_POST['tag_id']) : 'NULL';
        mysqli_query($conn, "UPDATE notes SET title='$title', content='$content', tag_id=$tag_id WHERE id=$note_id AND user_id=$user_id");
        header("Location: notes.php");
        exit();
    }

    if (isset($_POST['add_tag'])) {
        $tag_name = mysqli_real_escape_string($conn, trim($_POST['tag_name']));
        if (!empty($tag_name)) {
            mysqli_query($conn, "INSERT IGNORE INTO tags (user_id, name) VALUES ($user_id, '$tag_name')");
        }
        header("Location: notes.php");
        exit();
    }

    if (isset($_POST['delete_tag'])) {
        $tag_id = intval($_POST['tag_id']);
        mysqli_query($conn, "UPDATE notes SET tag_id = NULL WHERE tag_id = $tag_id AND user_id = $user_id");
        mysqli_query($conn, "DELETE FROM tags WHERE id = $tag_id AND user_id = $user_id");
        header("Location: notes.php");
        exit();
    }
}
?>
