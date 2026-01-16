// Admin projects helper functions exposed globally
(function () {
    const csrfToken = () => {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.content : '';
    };

    const shareBaseUrl = () => {
        const input = document.getElementById('shareUrl');
        return input?.dataset.shareBase || window.location.origin + '/project';
    };

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Close modal when clicking the overlay
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[id$="Modal"]').forEach((modal) => {
            modal.addEventListener('click', function (e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    this.classList.remove('flex');
                }
            });
        });
    });

    function archiveProject(projectId) {
        window.__adminProjectId = projectId;
        openModal('archiveModal');
    }

    function confirmArchive() {
        const projectId = window.__adminProjectId;
        if (!projectId) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/console/projects/${projectId}/archive`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = csrfToken();
        form.appendChild(csrf);

        document.body.appendChild(form);
        form.submit();
    }

    function shareProject(projectId) {
        window.__adminProjectId = projectId;
        const projectUrl = `${shareBaseUrl()}/${projectId}`;
        const shareInput = document.getElementById('shareUrl');
        if (shareInput) {
            shareInput.value = projectUrl;
        }
        openModal('shareModal');
    }

    function copyShareLink() {
        const shareUrl = document.getElementById('shareUrl');
        if (!shareUrl) return;
        shareUrl.select();
        document.execCommand('copy');
        alert('Link tersalin ke clipboard!');
        closeModal('shareModal');
    }

    function deleteProject(projectId, deleteForm) {
        window.__adminProjectId = projectId;
        window.__adminDeleteForm = deleteForm;
        const input = document.getElementById('deleteConfirmInput');
        const btn = document.getElementById('deleteConfirmBtn');
        if (input && btn) {
            input.value = '';
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
        }
        openModal('deleteModal');
    }

    function toggleDeleteButton() {
        const input = document.getElementById('deleteConfirmInput');
        const btn = document.getElementById('deleteConfirmBtn');
        if (!input || !btn) return;

        const isValid = input.value.toLowerCase() === 'hapus';
        btn.disabled = !isValid;
        if (isValid) {
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            btn.classList.add('hover:bg-rose-700', 'cursor-pointer');
        } else {
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btn.classList.remove('hover:bg-rose-700', 'cursor-pointer');
        }
    }

    function confirmDelete() {
        const input = document.getElementById('deleteConfirmInput');
        const form = window.__adminDeleteForm;
        if (input && input.value.toLowerCase() === 'hapus' && form) {
            form.submit();
        }
    }

    // Expose globally
    window.AdminProjects = {
        openModal,
        closeModal,
        archiveProject,
        confirmArchive,
        shareProject,
        copyShareLink,
        deleteProject,
        toggleDeleteButton,
        confirmDelete,
    };
})();
