var formatElement = document.querySelector("#game_format");
var nbTotalPlayerElement = document.querySelector("#game_nbTotalPlayer");
// Par défaut on n'affiche pas le champs nb de joueurs
nbTotalPlayerElement.style.display = 'none';
// On peut sélectionner l'élément précedent enfant du même parent avec previousSibling(https://developer.mozilla.org/en-US/docs/Web/API/Node/previousSibling)
nbTotalPlayerElement.previousSibling.style.display = 'none';
var selectElement = document.querySelector("#game_tournamentGame");
formatElement.addEventListener('change',displayNbPlayer);
selectElement.addEventListener('change',displayNbPlayer);
var nbOfTeamElement = document.querySelector("#game_nbOfTeam");
nbOfTeamElement.style.display = 'none';
nbOfTeamElement.previousSibling.style.display = 'none';
var nbOfPlayerValue = '';

function displayNbPlayer() {
  // on créé un tableau qui contiendra toutes les options (label et input)
  var nodes = nbTotalPlayerElement.childNodes;
  // par défaut chaque élément de ce tableau sera visible (cet état sera initialisé à chaque fois que l'on lancera la fonction)
  for(var i=0; i<nodes.length; i++){
    nodes[i].style.display = '';
  }
  // si on choisit mode tournoi
  if(selectElement.value === '1'){
    // si on choisit 1vs1 ou 2vs2
    if(formatElement.value == 1){
      // on affichera toutes les options de nombres de joueurs
      nbTotalPlayerElement.style.display = '';
      nbTotalPlayerElement.previousSibling.style.display = '';
      for(var i=0; i<nodes.length; i++){
        var nbPlayer = parseInt(nodes[i].value);
        // si l'élément input a une value qui n'est pas multiple de 3...
        if(nbPlayer%2 != 0 && !isNaN(nbPlayer) || nbPlayer>20){
          // ...on ne l'affiche pas...
          nodes[i].style.display = 'none';
          // ...même traitement pour le label qui lui est associé (nextSibling permet de sélectionner l'élément suivant parmi les enfants su même parent(https://developer.mozilla.org/en-US/docs/Web/API/Node/nextSibling))
          nodes[i].nextSibling.style.display = 'none';
        }
      }
    }
    else if(formatElement.value == 2){
      // on affichera toutes les options de nombres de joueurs
      nbTotalPlayerElement.style.display = '';
      nbTotalPlayerElement.previousSibling.style.display = '';
      for(var i=0; i<nodes.length; i++){
        var nbPlayer = parseInt(nodes[i].value);
        // si l'élément input a une value qui n'est pas multiple de 4...
        if((nbPlayer%4 != 0 && !isNaN(nbPlayer)) || nbPlayer>20){
          // ...on ne l'affiche pas...
          nodes[i].style.display = 'none';
          // ...même traitement pour le label qui lui est associé (nextSibling permet de sélectionner l'élément suivant parmi les enfants su même parent(https://developer.mozilla.org/en-US/docs/Web/API/Node/nextSibling))
          nodes[i].nextSibling.style.display = 'none';
        }
      }
    // si on choisit 3vs3
    } else if(formatElement.value == 3) {
        // d'abord on choisit d'afficher toutes les options
        nbTotalPlayerElement.style.display = '';
        nbTotalPlayerElement.previousSibling.style.display = '';
        // on va tester chaque élément du tableau nodes créé plus haut
        for(var i=0; i<nodes.length; i++){
          var nbPlayer = parseInt(nodes[i].value);
          // si l'élément input a une value qui n'est pas multiple de 3...
          if(nbPlayer%6 != 0 && !isNaN(nbPlayer)){
            // ...on ne l'affiche pas...
            nodes[i].style.display = 'none';
            // ...même traitement pour le label qui lui est associé (nextSibling permet de sélectionner l'élément suivant parmi les enfants su même parent(https://developer.mozilla.org/en-US/docs/Web/API/Node/nextSibling))
            nodes[i].nextSibling.style.display = 'none';
          }
        }
    // si on choisit une valeur différente de 1vs1, 2vs2 ou 3vs3
    } else {
        // on n'affichera pas l'élément nombre de joueurs
        nbTotalPlayerElement.style.display = 'none';
        nbTotalPlayerElement.previousSibling.style.display = 'none';
    }
  // si on ne choisit pas le mode tournoi
  } else {
    nbTotalPlayerElement.style.display = 'none';
    nbTotalPlayerElement.previousSibling.style.display = 'none';
  }
}
//-------------------------------------------------------------

