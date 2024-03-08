const form = document.getElementById("gm-create-form");
const checkboxError = document.getElementById("no-checkboxes");

//check if a checkbox is selected or not
function checkboxChecked() {
    const checkboxes = document.querySelectorAll("input.game-system-check");
    console.log(checkboxes);
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            return true;
        }
    }
    return false;
}

//show error messages if no checkbox is selected
form.addEventListener("submit", function (event) {
    if (!checkboxChecked()) {
        event.preventDefault();
        checkboxError.classList.remove("d-none");
    } else {
        checkboxError.classList.add("d-none");
    }
});
