import './bootstrap';
import './admin/projects';

document.addEventListener('DOMContentLoaded', () => {
	const copyButtons = document.querySelectorAll('.copy-btn');

	copyButtons.forEach((btn) => {
		btn.addEventListener('click', async () => {
			const text = btn.getAttribute('data-copy');
			if (!text) return;

			try {
				await navigator.clipboard.writeText(text);
				const original = btn.textContent;
				btn.textContent = 'Copied';
				btn.classList.add('border-cyan-300');
				setTimeout(() => {
					btn.textContent = original;
					btn.classList.remove('border-cyan-300');
				}, 1400);
			} catch (error) {
				console.error('Copy failed', error);
				alert('Gagal menyalin');
			}
		});
	});
});
