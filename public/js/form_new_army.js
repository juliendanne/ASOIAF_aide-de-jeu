


var buttonElements = document.querySelectorAll('#army_linkCombatUnit label');
var NCUbuttonElements = document.querySelectorAll('#army_linkNCU label');
var commanderElements = document.querySelectorAll('#army_commander label');

/*-------------------------V2--------------------------------------------*/
/*   let faction = document.querySelector('#army_faction');
faction.addEventListener("change", function(){
    let form = this.closest("form");
    let data = this.name + "=" + this.value;
    console.log(data);
    fetch(form.action, {
        method: form.getAttribute("method"),
        body: data,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded; charset:UTF-8;"
        }
    })
    .then(response => response.text())
    .then(html=> {
        let content = document.createElement("html");
        content.innerHTML = html;
        let nouveauSelect = content.querySelector("#army_linkCombatUnit");
        console.log(nouveauSelect);
        document.querySelector("#army_linkCombatUnit").replaceWith(nouveauSelect);
    })
});   */
/*-------------------------------------------------------------------------------*/
/*---------------------------V3--------------------------------------------------*/
/* const form = document.querySelector("#myForm")
const form_select_faction = document.querySelector("#army_faction");
const form_select_cu = document.querySelector("#army_linkCombatUnit");



const updateForm = async (data, url, method) =>{
    const req = await fetch( url, {
        method: method,
        body: data,
        headers: {
            'Content-Type': 'application/x-www-urlencoded',
            'charset': 'utf-8'
        }
    });
    const text = await req.text();
    return text;    
};
const parseTextToHtml = (text) =>{
    const parser = new DOMParser();
    const html = parser.parseFromString(text, text/html);
    return html;
};
const changeOptions = async (e) => {
    const requestBody = e.target.getAttribute('name') +'[]' + '=' + e.target.value;
    console.log(requestBody);
    const updateFormResponse = await updateForm(requestBody, form.getAttribute('action'), form.getAttribute('method'));
    console.log(updateFormResponse);
    const html = parseTextToHtml(updateFormResponse);
    const new_form_select_cu = html.querySelector('#army_linkCombatUnit');
    form_select_cu.innerHTML = new_form_select_cu.innerHTML;
};
form_select_faction.addEventListener('change', (e) => changeOptions(e));


console.log(form); */

/*---------------------------------------------------------------------------------------------*/

var factionButton = document.querySelector('#army_faction')
factionButton.addEventListener('change', displayUnit); 

for(var buttonElement of buttonElements){

    buttonElement.style.display='none';
    buttonElement.previousSibling.style.display = 'none';
}
for(var NCUbuttonElement of NCUbuttonElements){
    NCUbuttonElement.style.display='none';
    NCUbuttonElement.previousSibling.style.display = 'none';
}
for(var commanderElement of commanderElements){
    commanderElement.style.display='none';
    commanderElement.previousSibling.style.display = 'none';
}


/* for(var buttonElement of buttonElements){
    buttonElement.style.display = 'none';
    buttonElement.previousSibling.style.display = 'none'; 

        console.log('test');
    var imgurl = buttonElement.innerHTML;
    console.log(imgurl);
    var imagejavascript = document. createElement("img");
    imagejavascript.className="cardToEnlarge";
    imagejavascript.src = "../uploads/image_cards/"+imgurl;
    buttonElement.insertAdjacentElement('afterbegin', imagejavascript);
    console.log(imagejavascript.src);
    }
    for(var NCUbuttonElement of NCUbuttonElements){
        var NCUimgurl = NCUbuttonElement.innerHTML;
        var NCUimgjs = document.createElement("img");
        NCUimgjs.className="cardToEnlarge";
        NCUimgjs.src = "../uploads/image_cards/"+NCUimgurl;
        NCUbuttonElement.insertAdjacentElement('afterbegin', NCUimgjs);
    } */


function displayUnit() {


/* var inputs_linkCombatUnit = document.querySelectorAll('#army_linkCombatUnit input');

    for (var input_linkCombatUnit of inputs_linkCombatUnit){
        console.log(input_linkCombatUnit.getAttribute('data-faction'));
        console.log(factionButton.value);
            if (input_linkCombatUnit.getAttribute('data-faction') == factionButton.value){
                input_linkCombatUnit.style.display = '';
                input_linkCombatUnit.nextSibling.style.display = '';
            }
            else{
                input_linkCombatUnit.style.display = 'none';
                input_linkCombatUnit.nextSibling.style.display = 'none';

            }
    } */
        for(var buttonElement of buttonElements){

            buttonElement.style.display='none';
            buttonElement.previousSibling.style.display = 'none';

            console.log(buttonElement.getAttribute('data-faction'));
            if (factionButton.value == buttonElement.previousSibling.getAttribute('data-faction')){
                buttonElement.style.display='';
                buttonElement.previousSibling.style.display = '';
                console.log('test');
                var imgurl = buttonElement.innerHTML;
                console.log(imgurl);
                var imagejavascript = document. createElement("img");
                imagejavascript.className="cardToEnlarge";
                imagejavascript.src = "../uploads/image_cards/"+imgurl;
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
            if(factionButton.value==NCUbuttonElement.previousSibling.getAttribute('data-faction')){
                NCUbuttonElement.style.display='';
                NCUbuttonElement.previousSibling.style.display='';
                var NCUimgurl = NCUbuttonElement.innerHTML;
                var NCUimgjs = document.createElement("img");
                NCUimgjs.className="cardToEnlarge";
                NCUimgjs.src = "../uploads/image_cards/"+NCUimgurl;
                NCUbuttonElement.insertAdjacentElement('afterbegin', NCUimgjs);
            }else{
                NCUbuttonElement.style.display='none';
                NCUbuttonElement.previousSibling.style.display='none';
            }
        }
        for(var commanderElement of commanderElements){
            commanderElement.style.display='none';
            commanderElement.previousSibling.style.display='none';
            if(factionButton.value==commanderElement.previousSibling.getAttribute('data-faction')){
                commanderElement.style.display='';
                commanderElement.previousSibling.style.display='';
                var commanderImgUrl = commanderElement.innerHTML;
                console.log(commanderImgUrl);
                var commanderImgjs = document.createElement("img");
                commanderImgjs.className="cardToEnlarge";
                commanderImgjs.src = "../uploads/image_cards/"+commanderImgUrl;
                commanderElement.insertAdjacentElement('afterbegin', commanderImgjs);
            }else{
                commanderElement.style.display='none';
                commanderElement.previousSibling.style.display = 'none';
                }
        }
} 