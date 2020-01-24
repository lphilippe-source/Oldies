
/* 
Activité 2
*/

var listeLiens = [
    {
        titre: "So Foot",
        url: "http://sofoot.com",
        auteur: "yann.usaille"
    },
    {
        titre: "Guide d'autodéfense numérique",
        url: "http://guide.boum.org",
        auteur: "paulochon"
    },
    {
        titre: "L'encyclopédie en ligne Wikipedia",
        url: "http://Wikipedia.org",
        auteur: "annie.zette"
    }
];
creerLaPage();
function creerLaPage()
{
    var formElt = document.createElement("form");// création du formulaire
    var boutonElt = document.createElement("input");
    var auteurElt2 = document.createElement("input");
    var nomElt2 = document.createElement("input");
    var urlElt2 = document.createElement("input");
    var subElt = document.createElement("input");
    formElt.id="form2";
    boutonElt.setAttribute("type","button");
    boutonElt.id="ajoutLien";
    boutonElt.value = "Ajouter un lien";

    auteurElt2.setAttribute("type","text");
    auteurElt2.setAttribute("placeholder","votre nom");
    auteurElt2.setAttribute("required","required");
    auteurElt2.id="auteur2";
    auteurElt2.value="";
    nomElt2.setAttribute("type","text");
    nomElt2.setAttribute("placeholder","Nom du lien");
    nomElt2.setAttribute("required","required");
    nomElt2.id="nom2";
    nomElt2.value="";
    urlElt2.setAttribute("type","text");
    urlElt2.setAttribute("placeholder","Entrez l'url du lien");
    urlElt2.setAttribute("required","required");
    urlElt2.id="url2";
    urlElt2.value="";
    subElt.setAttribute("type","submit");
    subElt.id="sub2";
    subElt.value="Ajouter";
    document.getElementById("contenu").appendChild(formElt);
    document.getElementById("form2").appendChild(boutonElt);

    boutonElt.addEventListener("click",creerFormulaire);// au click création du frulaire

    function ajouterAuTableau(e)//on ajoute une entrée au debut de listeliens et on recré la page
        {
            e.preventDefault();
            console.log(e.target);
            console.log(listeLiens[0]);
               if(document.getElementById("url2").value.indexOf("http://")!==1||document.getElementById("url2").value.indexOf("https://")!==1)
                {
                    document.getElementById("url2").value= "http://"+ document.getElementById("url2").value;
                }
            let object = Object.create(listeLiens[0]);
            object.titre = nomElt2.value;
            object.url = urlElt2.value;
            object.auteur = auteurElt2.value;
            listeLiens.unshift(object);
            // let tabData = JSON.stringify(listeLiens);
            console.log(listeLiens);
            // Envoi du premier element du tableau au serveur
            ajaxPost("https://oc-jswebsrv.herokuapp.com/api/lien", listeLiens[0],
                function () {
                    // Le film est affiché dans la console en cas de succès
                    console.log("le lien " + JSON.stringify(listeLiens[0]) + " a été envoyé au serveur");
                },
                true // Valeur du paramètre isJson
            );

            document.getElementById("contenu").textContent="";
            e.stopPropagation();
            creerLaPage();
        }

    function creerFormulaire(e)//creation du formulaire d'ajout nom,titre,url,submit
        {
            document.getElementById("form2").appendChild(auteurElt2);
            document.getElementById("form2").appendChild(nomElt2);
            document.getElementById("form2").appendChild(urlElt2);
            document.getElementById("form2").appendChild(subElt);
            document.getElementById("form2").removeChild(document.getElementById("ajoutLien"));
        }
//activité 1
    

    //on affiche le contenu du serveur
    ajaxGet("https://oc-jswebsrv.herokuapp.com/api/liens",function(reponse){
        let i=0;
        let tableau = JSON.parse(reponse);
        console.log(tableau);
        tableau.forEach(propObjet =>
                       {
                        var titre = propObjet.titre;                //creation des elements
                        var  url = propObjet.url;
                        var auteur = propObjet.auteur;
                        var titreElt = document.createElement("a");
                        titreElt.id = titre;
                        titreElt.href = url;
                        var urlElt = document.createElement("span");
                        urlElt.id = url;
                        var auteurElt = document.createElement("p");
                        auteurElt.id = auteur;
                        var blocElt = document.createElement("article");
                        blocElt.id = "bloc"+i;

                        document.getElementById("contenu").appendChild(blocElt);  //insertion dans la page
                        blocElt.innerHTML=('<br\>');
                        document.getElementById("bloc"+i).appendChild(titreElt); 
                        titreElt.innerHTML=(titre);
                        document.getElementById("bloc"+i).appendChild(urlElt);
                        urlElt.innerHTML= (' '+url+'<br\>');
                        document.getElementById("bloc"+i).appendChild(auteurElt);
                        auteurElt.innerHTML=('Ajouté par '+auteur+'<br\>'+'<br\>'+'<br\>');

                        document.getElementById("bloc"+i).style.backgroundColor="white";   //style
                        document.getElementById("bloc"+i).style.marginBottom="20px";
                        var titreCss = document.getElementsByTagName("a")[i];
                        titreCss.style.textDecoration="none";
                        titreCss.style.color="#428bca";
                        titreCss.style.fontWeight="bold";
                        var urlCss = document.getElementsByTagName("span")[i];
                        urlCss.style.fontStyle="italic";

                        i++;
                       }
                      );
    })
    document.getElementById("form2").addEventListener("submit",ajouterAuTableau);// au submit ajouter au tableau

}
