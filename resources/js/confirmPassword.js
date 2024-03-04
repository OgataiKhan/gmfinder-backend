
const password = document.getElementById('password');
const secondPassword = document.getElementById('password-confirm');
const passwordCheck = document.getElementById('password-check');
const registerButton = document.getElementById('register-button');
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
        secondPassword.classList.remove('mt-4');
        passwordCheck.classList.remove('d-none');
        //disable register button
        registerButton.setAttribute('disabled', "");
    } else {
        secondPassword.classList.remove('border', 'border-danger', 'border-3');
        secondPassword.classList.add('mt-4');
        passwordCheck.classList.add('d-none');
        registerButton.removeAttribute('disabled', "");
    }
}

// secondPassword.addEventListener('keyup', secondValue);



