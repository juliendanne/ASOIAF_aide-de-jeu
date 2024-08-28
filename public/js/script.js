/* document.getElementById("searchbox").addEventListener('submit', submitSearch);

function submitSearch(event){
    event.preventDefault();
    console.log('coucou');
    var critere = document.getElementById('critere').value;
    console.log(critere);
     if(critere !== ''){
         var searchUrl = "http://localhost:8000/game/search_result/"+critere;
         window.location.href = searchUrl;

     }else{
         window.location.reload;
     }
} */
function submitSearch(){
    // on récupère la valeur critère et on la définit dans une variable
    var critere = document.getElementById('critere').value;
    console.log(critere);
    // si la variable critere n'est pas une chaine de caractères vide
     if(critere !== ''){
        // on définit une variable avec une adresse url affichant les résultats de la recherche du controller game à laquelle on ajoute la variable critere définit plus haut
         var searchUrl = "http://localhost:8000/game/search_result/"+critere;
         //on  charge cette page dans le navigateur
         window.location.href = searchUrl;

     }else{
        //on recharge la page actuelle
         window.location.reload;
     }
}