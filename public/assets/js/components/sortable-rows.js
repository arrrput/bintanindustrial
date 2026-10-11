/**
 * Drag & drop reordering for CMS tables.
 *
 * <tbody data-sortable-url="{{ route('cms.bies.reorder') }}">
 *     <tr data-id="12"><td class="drag-handle">…</td>…</tr>
 * </tbody>
 *
 * Rows are dragged by their ".drag-handle" cell. The new order (row ids, top to bottom)
 * is saved right away; if saving fails the rows jump back to their previous order.
 */
(function () {
    "use strict";

    if (typeof Sortable === 'undefined') return;

    const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('input[name="_token"]')?.value;

    const rowIds = (tbody) => Array.from(tbody.querySelectorAll('tr[data-id]')).map(tr => tr.dataset.id);

    function restore(tbody, ids) {
        ids.forEach(id => {
            const row = tbody.querySelector(`tr[data-id="${id}"]`);
            if (row) tbody.appendChild(row);
        });
    }

    async function save(tbody, previousIds) {
        const ids = rowIds(tbody);
        if (ids.join() === previousIds.join()) return;

        tbody.classList.add('is-saving');
        try {
            const res = await fetch(tbody.dataset.sortableUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids }),
            });
            const data = await res.json().catch(() => ({}));
            if (!res.ok) throw new Error(data.message || 'The new order could not be saved.');

            window.AppAlert?.success(data.message || 'Order saved.');
        } catch (err) {
            restore(tbody, previousIds);
            window.AppAlert?.error(err.message || 'The new order could not be saved.');
        } finally {
            tbody.classList.remove('is-saving');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('tbody[data-sortable-url]').forEach(tbody => {
            if (tbody.querySelectorAll('tr[data-id]').length < 2) {
                tbody.classList.add('is-static'); // nothing to reorder
            }

            let before = [];
            Sortable.create(tbody, {
                handle: '.drag-handle',
                draggable: 'tr[data-id]',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                onStart: () => { before = rowIds(tbody); },
                onEnd: () => save(tbody, before),
            });
        });
    });
})();
