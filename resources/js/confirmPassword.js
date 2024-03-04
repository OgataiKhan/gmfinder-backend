
const password = document.getElementById('password');
const secondPassword = document.getElementById('password-confirm');
const passwordCheck = document.getElementById('password-check');
let passwordValue = "";
let confirmPasswordValue = "";


//set the first password value
function firstValue() {
    passwordValue = password.value;
}

password.addEventListener('keyup', firstValue);

//set the second password value and check the values
function secondValue() {
    confirmPasswordValue = secondPassword.value;
    if (passwordValue !== confirmPasswordValue) {
        secondPassword.classList.add('border', 'border-danger', 'border-3');
        secondPassword.classList.remove('mt-4');
        passwordCheck.classList.remove('d-none');
    } else {
        secondPassword.classList.remove('border', 'border-danger', 'border-3');
        secondPassword.classList.add('mt-4');
        passwordCheck.classList.add('d-none');
    }
}

secondPassword.addEventListener('keyup', secondValue);



