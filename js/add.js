// write your js here...
p_email = document.getElementById('p_email');
icon = document.getElementById('icon');
divs = document.getElementsByClassName('danger');
form = document.getElementById('form');
div = document.getElementsByClassName('working')[0];


function hideAndRedirect() {
    if (div != null) {
        form.className = "displayNone";
        setTimeout(() => {
            window.location.href = "index.php";
        }, 2000)

    }

}


function addAlertIcon() {
    if (p_email.innerText == "EMAIL ALREADY EXISTS!") {
        icon.classList.remove('hide-icon');


    }


}
function addRedOutline() {
    for (i = 0; i < divs.length; i++) {
        if (divs[i].innerText != "") {
            input = divs[i].previousElementSibling;
            input.className = "error-input";
        }

    }

}

hideAndRedirect()

addRedOutline()


addAlertIcon();
