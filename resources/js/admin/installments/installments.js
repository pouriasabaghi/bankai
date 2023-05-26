import { manageRow } from "./../helpers/helpers";

const { add, remove, calculate } = manageRow(
    "#installments .manage-row__group .manage-row__items"
);

const addButton = document.querySelector(
    "#installments .manage-row__group .manage-row__button"
);
addButton && addButton.addEventListener("click", add);

const detail = document.querySelector("#installments-detail");
const options = {
    totalBox: detail?.querySelector(".installments__total"),
    creditorBox: detail?.querySelector(".installments__creditor"),
    totalPrice: detail?.querySelector("[data-total]")?.dataset.total,
    submitButton: document.querySelector(".submit-form"),
};
const amountInputs = document.querySelectorAll(
    "input[name^='installment'][name$='[amount]']"
);

const removeBtn = document.querySelectorAll("#installments .manage-row__button_delete");
removeBtn &&
    removeBtn.forEach((btn) => {
        btn.addEventListener("click", remove);
        btn.addEventListener(
            "click",
            calculate.bind(null, amountInputs, options)
        );
    });

detail && calculate(amountInputs, options);
amountInputs &&
    amountInputs.forEach((input) => {
        input.addEventListener(
            "keyup",
            calculate.bind(null, amountInputs, options)
        );
    });
