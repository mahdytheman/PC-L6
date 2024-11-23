var form = document.getElementById('validate');
var username = document.getElementsByName('username')[0];
var password = document.getElementsByName('password')[0];

//===================== if values not empty, notify php to catch values =====================
var username_valid = document.getElementsByName('username-valid')[0] ;
var password_valid = document.getElementsByName('password-valid')[0] ;

//submit event
form.addEventListener('submit', function(event) {
        
    var usernameValue = username.value.trim();
    var passwordValue = password.value.trim();

    checkEmpty(username,usernameValue,"You cannot leave this username field empty!",username_valid,event) ;
    checkEmpty(password,passwordValue,"You cannot leave this password field empty!",password_valid,event) ;


});
        // username: emptyness check
function checkEmpty(elem,elemValue,msg,phpFlag,event){        
    if (elemValue == "") { //these changes should take place --> persistent?
        event.preventDefault() ;
        // 1- Add Red outline --> error-input
        addRedOutLine(elem); //
        // 2- Show Error Message
        ShowErrordiv(elem,msg);
        makeInvalid(phpFlag) ;
    } else {
        removeOutLine(elem) ;
        hideErrordiv(elem) ;
        makeValid(phpFlag) ;

    }
}

      
// ================= FUnctions to execute if values empty ==============

function checkEqual(val1,val2){
    return (val1 === val2) ;
}


function makeInvalid(elem){
    elem.value = "" ;
}

 
function addRedOutLine(elem){ //function def --> parameter
    elem.classList.add('error-input') ;
}

function ShowErrordiv(elem,msg){
    var div = elem.nextElementSibling ;
    div.firstElementChild.innerText = msg ;
}


//===================== Functions to execute if values not empty ===========

function removeOutLine(elem){ //function def --> parameter
    elem.classList.remove('error-input') ;
}

function hideErrordiv(elem){
    var div = elem.nextElementSibling ;
    div.firstElementChild.innerText = "" ;
}

function makeValid(elem){
    elem.value = "valid" ;
}