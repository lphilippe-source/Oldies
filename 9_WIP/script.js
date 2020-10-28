window.addEventListener("load",function(){

    // CREATE ELEMENTS
    var modal= document.createElement("div");
    var elBtn = document.createElement("button");

    // HTML
    var elArt = document.getElementsByTagName('article');
    elBtn.setAttribute("class","btn");
    elBtn.innerText='Fermer';
    modal.setAttribute("style","position:fixed; background-color:rgba(0,0,0,0.7); width:100%;height:100%");

    // TRUNCATE TEXT
    var arrText=[];
    for (const el of elArt) {
        arrText.push(el.querySelectorAll("p")[1].innerText);
        truncated = el.querySelectorAll("p")[1].innerText;
        if (truncated.length > 150) {
            truncated = truncated.substr(0,150) + '...';
            el.querySelectorAll("p")[1].innerText= truncated;
        }
    };
   
    // EVENT MODAL
    for (const el of elArt) {
        el.addEventListener("click",function(e){
            if(this.getAttribute("style")==null || this.getAttribute("class")==null || this.getAttribute("class")=="paspop"){
                console.log(el.childNodes[5].innerText);
                arrText.forEach(element => {
                    if(element.indexOf(el.childNodes[5].innerText.substr(0,147))==0){
                        el.childNodes[5].innerText=element;
                    }
                });
                this.parentElement.appendChild(modal);
                this.append(elBtn);
                this.setAttribute("style","display:flex;flex-direction: column;overflow-y: auto;height: 100vh;font-size:1.5em;z-index:1;float:left;margin-top:1em;position:fixed;min-height:80%!important;width:80%!important"); 
            }
                closeMod = ()=>{
                    el.setAttribute("class","pop");
                    el.setAttribute("style","");
                    el.childNodes[5].innerText = el.childNodes[5].innerText.substr(0,150) + '...';
                    elBtn.remove();
                    modal.remove();
                    setTimeout(() => {
                        el.setAttribute("class","paspop");
                    }, 100);
                }
                modal.addEventListener("click",closeMod);
                elBtn.addEventListener("click",closeMod);
        });
    }
});