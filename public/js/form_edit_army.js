var buttonElements = document.querySelectorAll('#army_edit_linkCombatUnit label');
var NCUbuttonElements = document.querySelectorAll('#army_edit_linkNCU label');
var factionElement = document.querySelector(".factionElement");
var commanderElements = document.querySelectorAll('#army_edit_commander label');




console.log(buttonElements);
for(var buttonElement of buttonElements){

buttonElement.style.display='none';
buttonElement.previousSibling.style.display = 'none';
console.log(factionElement.getAttribute('data-faction'));
console.log(buttonElement.getAttribute('data-faction'));
if (factionElement.getAttribute('data-faction') == buttonElement.previousSibling.getAttribute('data-faction')){
    buttonElement.style.display='';
    buttonElement.previousSibling.style.display = '';
    console.log('test');
var imgurl = buttonElement.innerHTML;
console.log(imgurl);
var imagejavascript = document. createElement("img");
imagejavascript.className="cardToEnlarge";
imagejavascript.src = "../../uploads/image_cards/"+imgurl;
 buttonElement.insertAdjacentElement('afterbegin', imagejavascript);
 console.log(imagejavascript.src);
}else{
buttonElement.style.display='none';
buttonElement.previousSibling.style.display = 'none';
}
}
for(var NCUbuttonElement of NCUbuttonElements){
    NCUbuttonElement.style.display='none';
    NCUbuttonElement.previousSibling.style.display='none';
    if(factionElement.getAttribute('data-faction')==NCUbuttonElement.previousSibling.getAttribute('data-faction')){
        NCUbuttonElement.style.display='';
        NCUbuttonElement.previousSibling.style.display='';
        var NCUimgurl = NCUbuttonElement.innerHTML;
        var NCUimgjs = document.createElement("img");
        NCUimgjs.className="cardToEnlarge";
        NCUimgjs.src = "../../uploads/image_cards/"+NCUimgurl;
        NCUbuttonElement.insertAdjacentElement('afterbegin', NCUimgjs);
    }else{
        NCUbuttonElement.style.display='none';
        NCUbuttonElement.previousSibling.style.display='none';
    }
}
for(var commanderElement of commanderElements){
    commanderElement.style.display='none';
    commanderElement.previousSibling.style.display='none';
    if(factionElement.getAttribute('data-faction')==commanderElement.previousSibling.getAttribute('data-faction')){
        commanderElement.style.display='';
        commanderElement.previousSibling.style.display='';
        var commanderImgUrl = commanderElement.innerHTML;
        console.log(commanderImgUrl);
        var commanderImgjs = document.createElement("img");
        commanderImgjs.className="cardToEnlarge";
        commanderImgjs.src = "../../uploads/image_cards/"+commanderImgUrl;
        commanderElement.insertAdjacentElement('afterbegin', commanderImgjs);
    }else{
        commanderElement.style.display='none';
        commanderElement.previousSibling.style.display = 'none';
        }
}