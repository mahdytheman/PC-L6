var form = document.getElementById('validate');
var search = document.getElementsByName('search-q')[0];

//===================== if values not empty, notify php to catch values =====================
var search_valid = document.getElementsByName('search-q-valid')[0] ;

//submit event
form.addEventListener('submit', function(event) {
        
    var searchValue = search.value.trim();

    checkEmpty(search,searchValue,"You cannot leave this search field empty!",search_valid,event) ;


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