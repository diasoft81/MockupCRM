window.kanbanInterop = {
    initSortable: function (dotNetHelper) {
        document.querySelectorAll(".kanban-column").forEach(column => {
            new Sortable(column, {
                group: "kanban",
                animation: 150,
                onEnd: function (evt) {
                    const itemEl = evt.item;
                    const title = itemEl.querySelector("strong").innerText;
                    const newStageId = evt.to.id;
                    const newStage = newStageId.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

                    dotNetHelper.invokeMethodAsync("OnLeadMoved", title, newStage);
                }
            });
        });
    }
};
