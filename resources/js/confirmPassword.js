
const password = document.getElementById('password');
const secondPassword = document.getElementById('password-confirm');
const passwordCheck = document.getElementById('password-check');
const registerButton = document.getElementById('register-button');
const divPassword = document.getElementById('div-confirm-password')
let passwordValue = "";
let confirmPasswordValue = "";

let typingTimer;                //timer identifier

//on keyup, start the countdown
secondPassword.addEventListener('keyup', () => {
    clearTimeout(typingTimer);
    if (secondPassword.value) {
        typingTimer = setTimeout(secondValue, 600);
    }
});


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
        divPassword.classList.replace("mb-4", "mb-2");
        passwordCheck.classList.remove('d-none');
        //disable register button
        registerButton.setAttribute('disabled', "");
    } else {
        secondPassword.classList.remove('border', 'border-danger', 'border-3');
        divPassword.classList.replace("mb-2", "mb-4");
        passwordCheck.classList.add('d-none');
        registerButton.removeAttribute('disabled', "");
    }
}

// secondPassword.addEventListener('keyup', secondValue);



