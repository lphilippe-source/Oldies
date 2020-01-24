// au chargement de la page, afficher les images miniatures dans les catégories correspondantes.
//au click sur une images l'afficher en grand
//definir le nombre d'images a charger
//créer une liste avec toutes les images
//au click sur l'image en miniature, le bloc affiche cette image en grand
//evenement click changer le backgroundimage css du bloc.
//création dans la balise ul des balises li button et a
//quand on click sur le bouton miniature, l'image apparait en grand dans bloc.
//afficher le lien src dans balise de classe bloc
window.addEventListener("load",function ()                     
{  
    //document.getElementById("vignettes").innerHTML="";
    
                        const imgUsa = [];
                    for(let i=1 ; i<=24; i++)
                    {
                         imgUsa.push(i+".jpg") ;
                        console.log(imgUsa);
                    }
    
        
    imgUsa.forEach(ind=>
                    {
            var eltLi= document.createElement("li");
            var eltButton = document.createElement("button");
            var eltImg = document.createElement("img");
            const sansJpeg = ind.split(".");
            const puceLiId = "puce"+sansJpeg[0];
            const bouttonId = "boutton"+sansJpeg[0];
            eltLi.setAttribute("id",puceLiId);
            eltButton.setAttribute("type","button");
            eltButton.setAttribute("id",bouttonId);
        
            eltImg.setAttribute("src","img/"+ind);
        console.log(eltImg.getAttribute("src"));
            
            document.getElementById("vignettes").appendChild(eltLi);
            document.getElementById(puceLiId).appendChild(eltButton);
            document.getElementById(bouttonId).appendChild(eltImg);
                    }
                   )
    
}
                        )
document.addEventListener("click",function(e){
    if(e.target.getAttribute("src"))
    {
    console.log(e.target.getAttribute("src"));
        var img = e.target.getAttribute("src");
    document.querySelector(".bloc").style.backgroundImage = "url("+img+")";
    }
}
                         )
