function openModal() {
    document.getElementById('modalOverlay').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalOverlay').style.display = 'none';
}

function openEditModal(id, tagId, btn) {
    const card = btn.closest('.note-card');
    document.getElementById('editNoteId').value = id;
    document.getElementById('editTitle').value = card.dataset.title;
    document.getElementById('editContent').value = card.dataset.content;
    const sel = document.getElementById('editTagId');
    sel.value = tagId != null ? tagId : '';
    document.getElementById('editModalOverlay').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModalOverlay').style.display = 'none';
}

function openTagModal() {
    document.getElementById('tagModalOverlay').style.display = 'flex';
}

function closeTagModal() {
    document.getElementById('tagModalOverlay').style.display = 'none';
}

function syncToLocalStorage() {
    const cards = document.querySelectorAll('.note-card');
    const notes = [];
    cards.forEach(card => {
        notes.push({
            title: card.dataset.title,
            content: card.dataset.content
        });
    });
    localStorage.setItem('sol_notes', JSON.stringify(notes));
}

syncToLocalStorage();
