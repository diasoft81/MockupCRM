window.kanbanInterop = {
    initSortable: function (dotNetHelper) {
        document.querySelectorAll(".kanban-column").forEach(column => {
            if (column.dataset.sortableInitialized) return;
            column.dataset.sortableInitialized = "true";

            new Sortable(column, {
                group: "kanban",
                animation: 150,
                onStart: function (evt) {
                    evt.item.dataset.oldIndex = evt.oldIndex;
                    evt.item.dataset.oldParentId = evt.from.id;
                },
                onEnd: function (evt) {
                    const itemEl = evt.item;
                    const title = itemEl.querySelector("strong")?.innerText || '';
                    const newStageId = evt.to.id;
                    const newStage = newStageId.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

                    const oldIndex = parseInt(itemEl.dataset.oldIndex);
                    const oldParentId = itemEl.dataset.oldParentId;

                    dotNetHelper.invokeMethodAsync("OnLeadMoved", title, newStage, oldParentId, oldIndex);
                }
            });
        });
    },

    // 👇 Method untuk mengembalikan item ke tempat semula
    revertItem: function (leadTitle, fromColumnId, oldIndex) {
        const fromColumn = document.getElementById(fromColumnId);
        const allCards = Array.from(document.querySelectorAll(".task-card"));

        const item = allCards.find(card =>
            card.querySelector("strong")?.innerText.trim() === leadTitle.trim()
        );

        if (item && fromColumn) {
            // Force move back: remove then insert
            item.parentElement.removeChild(item);
            const referenceNode = fromColumn.children[oldIndex] || null;
            fromColumn.insertBefore(item, referenceNode);
        }
    }

};
