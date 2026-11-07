const board = document.querySelector('[data-board]');

if (board) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const error = document.querySelector('[data-board-error]');
    const live = document.querySelector('[data-board-live]');
    let dragged = null;

    const refreshCounts = () => {
        board.querySelectorAll('[data-column]').forEach((column) => {
            const count = column.querySelectorAll('[data-task]').length;
            column.querySelector('[data-count]').textContent = count;
            column.querySelector('[data-empty]').classList.toggle('hidden', count > 0);
        });
    };

    board.addEventListener('dragstart', (event) => {
        dragged = event.target.closest('[data-task]');

        if (dragged) {
            dragged.dataset.dragging = 'true';
            event.dataTransfer.effectAllowed = 'move';
        }
    });

    board.addEventListener('dragend', () => {
        delete dragged?.dataset.dragging;
        dragged = null;
    });

    board.querySelectorAll('[data-column]').forEach((column) => {
        column.addEventListener('dragover', (event) => {
            if (dragged) {
                event.preventDefault();
                column.dataset.over = 'true';
            }
        });

        column.addEventListener('dragleave', (event) => {
            if (!column.contains(event.relatedTarget)) {
                delete column.dataset.over;
            }
        });

        column.addEventListener('drop', async (event) => {
            event.preventDefault();
            delete column.dataset.over;

            const card = dragged;
            const from = card?.closest('[data-column]');

            if (!card || from === column) {
                return;
            }

            // Move the card right away, then save in the background.
            column.querySelector('[data-list]').prepend(card);
            refreshCounts();

            try {
                const response = await fetch(card.dataset.url, {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ status: column.dataset.column }),
                });

                if (!response.ok) {
                    throw new Error(response.status);
                }

                const task = await response.json();
                card.querySelector('[data-overdue]').classList.toggle('hidden', !task.overdue);
                live.textContent = `${board.dataset.moved} ${column.dataset.label}`;
            } catch {
                from.querySelector('[data-list]').prepend(card);
                refreshCounts();
                error.classList.remove('hidden');
                setTimeout(() => error.classList.add('hidden'), 4000);
            }
        });
    });
}
