const dataTable = (selector, options = {}) => {
    options.sortable = options.sortable ?? true;
    options.searchable = options.searchable ?? false;
    if (options.sortable) {
        const header = document.querySelectorAll(`${selector} th`);

        for (let i = 0; i < header.length; i++) {
            header[i].addEventListener("click", function () {
                sortTable(i);
            });
        }

        function sortTable(n) {
            let table,
                rows,
                switching,
                i,
                x,
                y,
                shouldSwitch,
                dir,
                switchcount = 0;
            table = document.querySelector(selector);
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[n];
                    y = rows[i + 1].getElementsByTagName("td")[n];
                    if (dir == "asc") {
                        if (
                            x.innerHTML.toLowerCase() >
                            y.innerHTML.toLowerCase()
                        ) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (
                            x.innerHTML.toLowerCase() <
                            y.innerHTML.toLowerCase()
                        ) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    }

    if (options.searchable) {
        function searchTable() {
            const table = document.querySelector(selector);
            const rows = table.querySelectorAll("tbody tr");
            const input = document.querySelector(`${selector}__search`);

            input?.addEventListener("keyup", function () {
                const searchText = this.value.toLowerCase();

                rows.forEach((row) => {
                    let match = false;

                    row.querySelectorAll("td").forEach((cell) => {
                        const cellText = cell.textContent.toLowerCase();

                        if (cellText.indexOf(searchText) !== -1) {
                            match = true;
                        }
                    });

                    if (match) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        }
        searchTable()
    }
};
dataTable('table');


/**
 * Shortcuts
 */
const toggleSidebar = document.querySelector(".sidebar-toggle");
document.addEventListener("keydown", shortcuts);
function shortcuts(event) {
    if (event.ctrlKey && event.code === "KeyB") {
        toggleSidebar.click();
    }
}
