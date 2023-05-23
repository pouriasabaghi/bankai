import { manageRow } from "./../helpers/helpers";

const { add, remove } = manageRow(".manage-row__group .manage-row__items");
const addButton = document.querySelector(
    ".manage-row__group .manage-row__button"
);
addButton && addButton.addEventListener("click", add);

const removeBtn = document.querySelectorAll(".manage-row__button_delete")
removeBtn &&  removeBtn.forEach((btn) => btn.addEventListener("click", remove));
