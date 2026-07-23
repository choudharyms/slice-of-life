<?php
include('checkNotes.php');
include('header.php');

$filter_tag = isset($_GET['tag']) ? intval($_GET['tag']) : 0;

if ($filter_tag) {
    $result = mysqli_query($conn, "SELECT n.*, t.name as tag_name FROM notes n LEFT JOIN tags t ON n.tag_id = t.id WHERE n.user_id = $user_id AND n.tag_id = $filter_tag ORDER BY n.id DESC");
} else {
    $result = mysqli_query($conn, "SELECT n.*, t.name as tag_name FROM notes n LEFT JOIN tags t ON n.tag_id = t.id WHERE n.user_id = $user_id ORDER BY n.id DESC");
}
$notes = mysqli_fetch_all($result, MYSQLI_ASSOC);

$tags_result = mysqli_query($conn, "SELECT * FROM tags WHERE user_id = $user_id ORDER BY id ASC");
$tags = mysqli_fetch_all($tags_result, MYSQLI_ASSOC);
?>

<div class="container">
    <div class="topbar">
        <h1><img src="images/notes.png" alt="Notes">Slice Of Life</h1>
        <div class="user-info">
            <span>Hi, <?php echo $_SESSION['user_name']; ?></span>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="tag-bar">
        <a href="notes.php" class="tag-filter-btn <?php echo $filter_tag === 0 ? 'active' : ''; ?>">All</a>
        <?php foreach ($tags as $tag): ?>
        <a href="notes.php?tag=<?php echo $tag['id']; ?>" class="tag-filter-btn <?php echo $filter_tag === $tag['id'] ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($tag['name']); ?>
        </a>
        <?php endforeach; ?>
        <button class="add-tag-btn" onclick="openTagModal()">+ Tag</button>
    </div>

    <button onclick="openModal()"><img src="images/edit1.png" alt="Create Note">Create Note</button>

    <div class="notes-grid" id="notesGrid">
        <?php foreach ($notes as $note): ?>
        <div class="note-card" data-title="<?php echo htmlspecialchars($note['title']); ?>" data-content="<?php echo htmlspecialchars($note['content']); ?>">
            <h3><?php echo htmlspecialchars($note['title']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($note['content'])); ?></p>

            <?php if (!empty($note['tag_name'])): ?>
            <span class="tag-pill"><?php echo htmlspecialchars($note['tag_name']); ?></span>
            <?php endif; ?>

            <div class="card-actions">
                <button class="edit-note-btn" onclick="openEditModal(<?php echo $note['id']; ?>, <?php echo $note['tag_id'] ?? 'null'; ?>, this)">
                    <img src="images/edit.png" alt="Edit">
                </button>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
                    <button type="submit" name="delete_note" class="delete-btn">
                        <img src="images/delete.png" alt="Delete">
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal-overlay" id="modalOverlay">
    <div class="modal-box">
        <h2>New Note</h2>
        <form action="" method="post">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="content" placeholder="Write your note..." rows="5" required></textarea>
            <select name="tag_id">
                <option value="">No Tag</option>
                <?php foreach ($tags as $tag): ?>
                <option value="<?php echo $tag['id']; ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="modal-buttons">
                <button type="submit" name="add_note">Save Note</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="editModalOverlay">
    <div class="modal-box">
        <h2>Edit Note</h2>
        <form action="" method="post">
            <input type="hidden" name="note_id" id="editNoteId">
            <input type="text" name="title" id="editTitle" placeholder="Title" required>
            <textarea name="content" id="editContent" placeholder="Write your note..." rows="5" required></textarea>
            <select name="tag_id" id="editTagId">
                <option value="">No Tag</option>
                <?php foreach ($tags as $tag): ?>
                <option value="<?php echo $tag['id']; ?>"><?php echo htmlspecialchars($tag['name']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="modal-buttons">
                <button type="submit" name="edit_note">Update Note</button>
                <button type="button" onclick="closeEditModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="tagModalOverlay">
    <div class="modal-box">
        <h2>Manage Tags</h2>
        <form action="" method="post" class="tag-add-form">
            <input type="text" name="tag_name" placeholder="New tag name..." required>
            <button type="submit" name="add_tag" class="tag-add-submit">Add</button>
        </form>
        <div class="tag-list">
            <?php foreach ($tags as $tag): ?>
            <div class="tag-manage-row">
                <span><?php echo htmlspecialchars($tag['name']); ?></span>
                <?php if (!in_array($tag['name'], ['Personal', 'Work'])): ?>
                <form action="" method="post">
                    <input type="hidden" name="tag_id" value="<?php echo $tag['id']; ?>">
                    <button type="submit" name="delete_tag" class="tag-delete-btn">✕</button>
                </form>
                <?php else: ?>
                <span class="tag-locked">locked</span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="modal-buttons">
            <button type="button" onclick="closeTagModal()">Close</button>
        </div>
    </div>
</div>

<script src="script.js"></script>
<?php include('footer.php'); ?>
