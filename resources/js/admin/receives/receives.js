import { manageRow } from "./../helpers/helpers";
import { toggleType, changeReceiveBox } from "./functions";



const { add, remove } = manageRow(
    "#receives .manage-row__group .manage-row__items"
);

// ad row buttons
const addButton = document.querySelector(
    "#receives .manage-row__group .manage-row__button"
);
addButton &&
    addButton.addEventListener("click", add.bind(null, addReceiveByType)) &&
    addButton.addEventListener("mouseover", add.bind(null, addReceiveByType));

// handling type. deposit must shown or check inputs
function addReceiveByType(container, e) {
    const el = e.target.closest("button")
    const selectedType = el.dataset.type;

    changeReceiveBox(container, selectedType)
}

// remove rows
const removeBtn = document.querySelectorAll(
    "#receives .manage-row__button_delete"
);
removeBtn &&
    removeBtn.forEach((btn) => {
        btn.addEventListener("click", remove);
    });

// toggle type before click on add receive button
const { toggle } = toggleType(".add-receive-toggle-type-container");
const addReceiveToggleButtons = document.querySelector('.add-receive-toggle-type-container').querySelectorAll(
    ".toggle-type-buttons"
);
addReceiveToggleButtons &&
    addReceiveToggleButtons.forEach((button) =>
        button.addEventListener("click", toggle)
    );


// toggle type from inside of receive

const toggleReceiveTypeBtn = document.querySelector('.manage-row__group').querySelectorAll(
    ".inside-toggle-type-buttons"
);
toggleReceiveTypeBtn &&
    toggleReceiveTypeBtn.forEach((button) =>
        button.addEventListener("click", handleInsideToggle)
    );

function handleInsideToggle(e) {
    const el = e.target;
    const container = el.closest(".manage-row__items")
    const selectedType = el.dataset.toggleType
    // toggleTypeFromInside();
    changeReceiveBox(container, selectedType)
}
