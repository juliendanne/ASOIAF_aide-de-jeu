var buttonElements = document.querySelectorAll('#line_army_attachments label');

var factionElement = document.querySelector(".factionElement");





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
imagejavascript.src = "../../../uploads/image_cards/"+imgurl;
 buttonElement.insertAdjacentElement('afterbegin', imagejavascript);
 console.log(imagejavascript.src);
}else{
buttonElement.style.display='none';
buttonElement.previousSibling.style.display = 'none';
}
}
