function ajaxGet(url,callback){
    var req = new XMLHttpRequest();
    req.open("GET", url);
    req.addEventListener("load", function () {
        let reponse = req.responseText;
        callback(reponse);
    });
    req.send();
}
const elText= document.getElementById("text");
const elChamps=document.getElementById("champsBataille");
const elConsole=document.getElementById("console");

elText.innerHTML="";

function afficherData(reponse){
    elText.innerHTML="";
    var rep = JSON.parse(reponse);
    const elTr= document.createElement("tr");
    elText.appendChild(elTr);
    const tabRep =Object.entries(rep[0])[0][0];
    let repMap=Object.entries(rep[0]).length;
    for(i=0;i<repMap;i++){
        let elTd= document.createElement("td");
        elTr.appendChild(elTd);
        elTd.innerHTML =Object.entries(rep[0])[i][0];
    }
    Object.entries(rep).map(([key, value]) => {
        elText.appendChild(elTr2= elTr.cloneNode(true));
        let j=0;
        Object.entries(value).map(([key1, value2]) =>{
            elTr2.childNodes[j].innerHTML=value2;
            j++;
        });
    });
}
function afficherPerso(reponse){
    elText.innerHTML="";
    let rep = JSON.parse(reponse);
    Object.entries(rep).map(([key,value])=>{
        elText.innerHTML+="<div>"+key+"</div><div>"+value+"</div><br/>";
    });
    elChamps.innerHTML+="<div id="+rep.nom+"><div>nom: "+rep.nom+"</div><div>degats:"+rep.degats+"</div></div>";
}
function creerPerso(reponse){
    elText.innerHTML=reponse;
}

function attaquePerso(reponse){
    let affichage = JSON.parse(reponse);
    let arr = Object.entries(affichage);
    let logLength = arr.length;
    const textLog = logLength-3;
    // elText.innerHTML=affichage;
    console.log(arr);
    console.log(arr[logLength-1][1][0]);
    if(document.getElementById(arr[logLength-1][1][0])){
        document.getElementById(arr[logLength-1][1][0]).setAttribute('style','background:green');
        document.getElementById(arr[logLength-1][1][0]).childNodes[1].innerHTML=arr[logLength-1][1][1];
    }
    if(document.getElementById(arr[logLength-2][1][0])){
        document.getElementById(arr[logLength-2][1][0]).setAttribute('style','background:green');
        document.getElementById(arr[logLength-2][1][0]).childNodes[1].innerHTML=arr[logLength-2][1][1];
    }
    elText.innerHTML="";
    for(i=0;i<=textLog;i++){
        // console.log(arr[i][1]);
        let strLog=arr[i][1];

        setTimeout(function(){
            elText.innerHTML+=strLog+'<br/>';
            }
            , 1000);
    }
}
document.getElementById("sorti").addEventListener("click",function(e){
    e.preventDefault();
    ajaxGet('http://localhost/ocr/ajax.php?params=1',afficherData);
});
document.getElementById("usePerso").addEventListener("click",function(e){
    e.preventDefault();
      
    let nom= document.getElementById("champ").value;
    ajaxGet('http://localhost/ocr/ajax.php?params=2&nom='+nom,afficherPerso);
});
document.getElementById("createPerso").addEventListener("click",function(e){
    e.preventDefault();
    let checkC = '';
    let nom= document.getElementById("champ").value;
    if(document.getElementById('guerrier').value=='yes')checkC= 'guerrier';
    else checkC= 'magicien';
    ajaxGet('http://localhost/ocr/ajax.php?params=3&nom='+nom+'&checkC='+checkC,creerPerso);
});
document.getElementById("attaque").addEventListener("click",function(e){
    e.preventDefault();
      let console = elConsole.innerHTML;
      console = console.replace(' vous confirmez?','');
      console = console.replace(' attaque ',',');
    ajaxGet('http://localhost/ocr/ajax.php?params=4&cons='+console,attaquePerso);
});
document.getElementById("sort").addEventListener("click",function(e){
    e.preventDefault();
      let console = elConsole.innerHTML;
      console = console.replace(' vous confirmez?','');
      console = console.replace(' attaque ',',');
    ajaxGet('http://localhost/ocr/ajax.php?params=5&cons='+console,attaquePerso);
});
document.getElementById('guerrier').addEventListener('change',function(e){
    if(this.value=='yes'){
        this.value='no';
        this.checked=false;
    }
    else {
        document.getElementById('magicien').value='no';
        this.value='yes';
        document.getElementById('magicien').checked=false;
        this.checked=true; 
    }
    e.stopPropagation();
});
document.getElementById('magicien').addEventListener('change',function(e){

    if(this.value=='yes'){
        this.checked=false;
        this.value='no';
    }
    else {
        document.getElementById('guerrier').value='no';
        this.value='yes';
        document.getElementById('guerrier').checked=false;
        this.checked=true;
    }
        e.stopPropagation();
});
document.getElementById("champsBataille").addEventListener('click',function(e){
    //selection du noeud parent de la zone clicker
    //on regarde s'il a l'attribut style si oui on l'enlève
    //si non pour chaque elmt de chmpsdeBat on enlève le style
    //et on mets l'attribut style sur le parent de la zone clicker
    if(e.target.parentNode.hasAttribute("style")){
        e.target.parentNode.removeAttribute("style");
    }
    else{
        this.childNodes.forEach(element => {
            element.removeAttribute("style");
            // element.removeAttribute('selected','1');

        });
        e.target.parentNode.setAttribute('style','background:red');
        const term =' est selectionné(e), veuillez choisir un adversaire';
        //si la string ne match pas
        //on affiche l'id dans la console
        //si elle match, on affiche l'adversaire
        if(elConsole.innerHTML.indexOf(term)==-1){
            elConsole.innerHTML = e.target.parentNode.id+term;
            e.target.parentNode.setAttribute('selected','1');
        }
        else{
            this.childNodes.forEach(element => {
                if(element.hasAttribute('selected','1')){
                    elConsole.innerHTML = element.id+' attaque '+e.target.parentNode.id+' vous confirmez?';
                }
            });
        }
    }
    e.stopPropagation();
});

