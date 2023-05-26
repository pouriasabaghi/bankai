export const  toggleType = (containerSelector) => {
    const container = document.querySelector(containerSelector);
    const label = container.querySelector(".type-label");
    const button = container.querySelector(".manage-row__button");

    function toggle(e) {
        const type = e.target.dataset.toggleType;
        if (button) {
            button.dataset.type = type;
        }
        label.textContent = e.target.textContent;
    }

    return {
        toggle,
    };
}


export const changeReceiveBox = (container, selectedType) => {
    const types = container.querySelectorAll("[data-type]"); // receive rows data-type
    const receiveTypInput = container.querySelector('input.receive-type')
    receiveTypInput.value = selectedType;
    types.forEach((type) => type.classList.add("d-none"));
    container.querySelector(`[data-type="${selectedType}"]`).classList.remove("d-none");
    container.querySelector('.type-label').textContent = selectedType == 'check' ? 'چک'  : 'واریز';
}

