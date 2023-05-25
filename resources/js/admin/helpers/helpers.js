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
        str = str.replace(/,/g, "");
    }

    return str;
};

export const manageRow = (selector) => {
    function add() {
        let row = document.querySelector(`${selector}[data-row-count='1']`);
        if (row) {
            while (!row.classList.contains("d-none")) {
                row = row.nextElementSibling;
            }
            row.classList.remove("d-none");
        }
    }

    function remove(e) {
        const container = e.target.closest(selector);

        const inputs = container.querySelectorAll("input");

        inputs && inputs.forEach((input) => {
            input.value = ""
            input.checked = false;
        });
        container.classList.add("d-none");
    }

    function calculate(amountInputs, options, e) {
        let { totalBox, creditorBox, totalPrice, submitButton } = options;
        console.log(options);
        totalPrice = +totalPrice;
        let totalInstallmentsAmount = [...amountInputs].reduce(
            (total, input) => {
                if (input.value != "") {
                    total = total + parseInt(fix_number(input.value ?? 0));
                }
                return total;
            },
            0
        );

         // filling total installments amount element
        totalBox.textContent = totalInstallmentsAmount <= totalPrice
        ? totalInstallmentsAmount.toLocaleString()
        : totalPrice.toLocaleString()
        let creditor = totalPrice - totalInstallmentsAmount;
       // creditorBox.textContent = creditor > 0 ? creditor.toLocaleString() : 0;
        creditorBox.textContent = creditor.toLocaleString() ;
        if (creditor !== 0) {
            creditorBox.classList.add("fw-bold");
            creditorBox.classList.add("text-danger");
        } else {
            creditorBox.classList.remove("fw-bold");
            creditorBox.classList.remove("text-danger");
        }

        if (submitButton) {
            if (creditor == 0) {
                submitButton.removeAttribute("disabled");
            } else {
               submitButton.setAttribute("disabled", "true");
            }
        }
    }

    return {
        add,
        remove,
        calculate,
    };
};
