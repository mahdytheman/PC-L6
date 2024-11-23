var form = document.getElementById('validate');
var username = document.getElementsByName('username')[0];
var email = document.getElementsByName('email')[0];
var password1 = document.getElementsByName('password1')[0];
var password2 = document.getElementsByName('password2')[0];

//===================== if values not empty, notify php to catch values =====================
var username_valid = document.getElementsByName('username-valid')[0] ;
var email_valid = document.getElementsByName('email-valid')[0] ;
var password_valid = document.getElementsByName('password-valid')[0] ;

//submit event
form.addEventListener('submit', function(event) {
        
    var usernameValue = username.value.trim();
    var emailValue = email.value.trim();
    var password1Value = password1.value.trim();
    var password2Value = password2.value.trim();

    checkEmpty(username,usernameValue,"You cannot leave this username field empty!",username_valid,event) ;
    checkEmpty(email,emailValue,"You cannot leave this email field empty!",email_valid,event) ;
    checkEmpty(password1,password1Value,"You cannot leave this password field empty!",password_valid,event) ;
    checkEmpty(password2,password2Value,"You cannot leave this password field empty!",password_valid,event) ;


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
        // not empty
        // is it a password field or other
    if (elem.type !== "password"){
        removeOutLine(elem) ;
        hideErrordiv(elem) ;
        makeValid(phpFlag) ;
    } else{
            // this means it is a password
    if (elem.name == "password2") {
        
            // if for second password check for equalty
        if (checkEqual(password1.value, password2.value)){
            //remove all error and set hidden to valid
        removeOutLine(elem) ;
        hideErrordiv(elem) ;
        makeValid(phpFlag) ; 
        } else{
        // not equal
        event.preventDefault() ;
        // 1- Add Red outline --> error-input
        addRedOutLine(elem); //
        // 2- Show Error Message
        ShowErrordiv(elem,"Passwords need to match");
        makeInvalid(phpFlag) ;
    }


    } else {
        //non empty,  password field, first password field
        removeOutLine(elem) ;
        hideErrordiv(elem) ; 
    }
    } 
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