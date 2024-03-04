const form = document.getElementById('gm-create-form');
const checkboxError = document.getElementById('no-checkboxes');

//check if a checkbox is selected or not
function checkboxChecked() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            return true;
        }
    }
    return false;
}

//prevent the form submit if no checkbox is checked
// function noChecked() {
//     if (!checkboxChecked()) {
//         event.preventDefault;
//         alert('Select at least one game system')
//     }
// }


form.addEventListener('submit', function (event) {
    if (!checkboxChecked()) {
        event.preventDefault();
        checkboxError.classList.remove('d-none');
    } else {
        checkboxError.classList.add('d-none');
    }
})
