export const fix_number = (str) => {
    let persianNumbers = [
        /۰/g,
        /۱/g,
        /۲/g,
        /۳/g,
        /۴/g,
        /۵/g,
        /۶/g,
        /۷/g,
        /۸/g,
        /۹/g,
    ];
    let arabicNumbers = [
        /٠/g,
        /١/g,
        /٢/g,
        /٣/g,
        /٤/g,
        /٥/g,
        /٦/g,
        /٧/g,
        /٨/g,
        /٩/g,
    ];

    if (typeof str === "string") {
        for (var i = 0; i < 10; i++) {
            str = str
                .replace(persianNumbers[i], i)
                .replace(arabicNumbers[i], i);
        }
    }
    return str;
};

export const manageRow = (selector) => {
    let rowCounter = 1;

    function add() {
        rowCounter++;
        let row = document.querySelector(
            `${selector}[data-row-count="${rowCounter}"]`
        );
        if (row) {
            while (!row.classList.contains('d-none')) {
                rowCounter = rowCounter + 1;
                row = document.querySelector( `${selector}[data-row-count="${rowCounter}"]`)

            }
            row.classList.remove("d-none")
        }
    }

    function remove(e) {
        let container = e.target.closest(selector);
        let inputs = container.querySelectorAll("input");
        inputs && inputs.forEach((input) => (input.value = ""));
        container.classList.add("d-none");
    }
    return {
        add,
        remove,
    };
};
