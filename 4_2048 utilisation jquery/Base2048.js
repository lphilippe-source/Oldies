$.fn.game2048 = function()
{
    this.append(generateMap());
    function generateMap(){
        let table = $("<table></table>");
        let div = $("<div></div>");
        div.append(table);
        div.prepend("<label for='button'></label><input id='button' name='bouton' value='new game' type='button'>");
        for(j=1;j<5;j++){
            table.append("<tr></tr>");
            for(i=1;i<5;i++){
                table.find("tr:last").append("<td class='x"+i+" "+"y"+j+"' value='null'></td>");
            }
        }
    
        return div;                         
    }
    function twoOrFour(){
        let twoorfour = Math.ceil(Math.random()*10)
        if(twoorfour===10)
        return 4;
        else return 2;
    }
    generateCell(2);
    function generateCell(nb){
        let number, x, y;
                if(nb>0){
                number = 1 + Math.floor(Math.random() * 16);
                x= number%4+1;
                y= Math.ceil(number/4);
                    if(($(".x"+x+".y"+y).attr('value')==="null")){
                        $(".x"+x+".y"+y).attr('value',"");
                        $(".x"+x+".y"+y).append("<div class='c1' value=''></div>");
                        let val = twoOrFour();
                        // console.log(val);
                        if(val===4)
                        $(".x"+x+".y"+y).children().removeClass().addClass("c2");

                        setValue($(".x"+x+".y"+y).children());
                        // div= $(".x"+x+".y"+y).append("2");
                        nb--;
                        generateCell(nb);
                    }else
                    generateCell(nb);
                }
                return;
    }
    function move(key){
        for(y=1;y<5;y++){
            for(x=1;x<5;x++){
                // console.log($(".x"+x+".y"+y).children().attr('class'));
                // console.log($(".x"+x+".y"+y).children().attr('value'));
                if(key==="left"){
                    if(x>=2){
                        movefaster(x);
                        function movefaster(x){
                            if(($(".x"+(x-1)+".y"+y).attr('value')==="null")&&($(".x"+x+".y"+y).attr('value')==="")){
                                let divMove = $(".x"+x+".y"+y).children().detach();
                                $(".x"+(x-1)+".y"+y).attr('value',"");
                                divMove.appendTo($(".x"+(x-1)+".y"+y));
                                $(".x"+x+".y"+y).attr('value',"null");
                                movefaster((x-1));
                            }
                        }
                    }
                    if(y===4 && x===4)
                    mergeItem(x,(x-1),"x");
                }
                if(key==="up"){
                    if(y>=2){
                        movefaster(y);
                        function movefaster(y){
                            if(($(".x"+x+".y"+(y-1)).attr('value')==="null")&&($(".x"+x+".y"+y).attr('value')==="")){
                                let divMove = $(".x"+x+".y"+y).children().detach();
                                $(".x"+x+".y"+(y-1)).attr('value',"");
                                divMove.appendTo($(".x"+x+".y"+(y-1)));
                                $(".x"+(x)+".y"+y).attr('value',"null");
                                movefaster((y-1));
                                return;
                            }
                        }
                    }
                    if(y===4 && x===4)
                    mergeItem(y,(y-1),"y");
                }
                // else mergeItem(x,y);
            }
        }
        for(x=4;x>0;x--){
            for(y=4;y>0;y--){
                if(key==="right"){
                    if(x<=3){
                        movefaster(x);
                        function movefaster(x){

                            if(($(".x"+(x+1)+".y"+y).attr('value')==="null")&&($(".x"+x+".y"+y).attr('value')==="")){
                                let divMove = $(".x"+x+".y"+y).children().detach();
                                $(".x"+(x+1)+".y"+y).attr('value',"");
                                divMove.appendTo($(".x"+(x+1)+".y"+y));
                                $(".x"+x+".y"+y).attr('value',"null");
                                movefaster((x+1));
                            }
                        
                        }
                    }
                    if(y===4 && x===4)
                    mergeItem(x,(x+1),"x");
                }
                
                if(key==="down"){
                    if(y<=3){
                        movefaster(y);
                        function movefaster(y){
                                if(($(".x"+x+".y"+(y+1)).attr('value')==="null")&&($(".x"+x+".y"+y).attr('value')==="")){
                                    let divMove = $(".x"+x+".y"+y).children().detach();
                                    $(".x"+x+".y"+(y+1)).attr('value',"");
                                    divMove.appendTo($(".x"+x+".y"+(y+1)));
                                    $(".x"+(x)+".y"+y).attr('value',"null");
                                    movefaster((y+1));
                                }
                        }         
                    }
                    if(y===4 && x===4)
                    mergeItem(y,(y+1),"y");
                }
            }
        }
    }
    function mergeItem(pos,direction,axe){
        if (pos>direction){
           if(axe==="y"){
            for(let y=1;y<5;y++){
                for(let x=1;x<5;x++){
                    if(y<=3){
                        if(($(".x"+x+".y"+y).attr('value')==="") && ($(".x"+x+".y"+(y+1)).attr('value')==="")){
                                let varClass =$(".x"+x+".y"+y).children().attr('class');
                                let varClass2 =$(".x"+x+".y"+(y+1)).children().attr('class');
                                if(varClass===varClass2){
                                    $(".x"+x+".y"+(y+1)).attr('value','null');
                                    $(".x"+x+".y"+(y+1)).children().remove();
                                    // console.log($(".x"+x+".y"+y).attr('class'));
                                    let changeClass = parseInt($(".x"+x+".y"+y).children().attr('class').slice(1),10);
                                    changeClass +=1;
                                    let newCl = $(".x"+x+".y"+y).children().attr('class','c'+changeClass);
                                    setValue($(".x"+x+".y"+y).children());
                                }
                        }
                    }
                }
            }    
           }
           if(axe==="x"){
            for(let y=1;y<5;y++){
                for(let x=1;x<5;x++){
                    if(x<=3){
                        if(($(".x"+x+".y"+y).attr('value')==="") && ($(".x"+(x+1)+".y"+y).attr('value')==="")){
                                let varClass =$(".x"+x+".y"+y).children().attr('class');
                                let varClass2 =$(".x"+(x+1)+".y"+y).children().attr('class');
                                if(varClass===varClass2){
                                    $(".x"+(x+1)+".y"+y).attr('value','null');
                                    $(".x"+(x+1)+".y"+y).children().remove();
                                    // console.log($(".x"+x+".y"+y).attr('class'));
                                    let changeClass = parseInt($(".x"+x+".y"+y).children().attr('class').slice(1),10);
                                    changeClass +=1;
                                    let newCl = $(".x"+x+".y"+y).children().attr('class','c'+changeClass);
                                    setValue($(".x"+x+".y"+y).children());
                                }
                        }
                    }
                }
            }    
           }
        }
        if (pos<direction){
            if(axe==="y"){
             for(let x=4;x>0;x--){
                 for(let y=4;y>0;y--){
                     if(y>1){
                         if(($(".x"+x+".y"+y).attr('value')==="") && ($(".x"+x+".y"+(y-1)).attr('value')==="")){
                                 let varClass =$(".x"+x+".y"+y).children().attr('class');
                                 let varClass2 =$(".x"+x+".y"+(y-1)).children().attr('class');
                                 if(varClass===varClass2){
                                     $(".x"+x+".y"+(y-1)).attr('value','null');
                                     $(".x"+x+".y"+(y-1)).children().remove();
                                     console.log($(".x"+x+".y"+y).attr('class'));
                                     let changeClass = parseInt($(".x"+x+".y"+(y)).children().attr('class').slice(1),10);
                                     changeClass +=1;
                                     let newCl = $(".x"+x+".y"+(y)).children().attr('class','c'+changeClass);
                                     setValue($(".x"+x+".y"+(y)).children());
                                 }
                         }
                     }
                 }
             }    
            }
            if(axe==="x"){
             for(let y=1;y<5;y++){
                 for(let x=1;x<5;x++){
                     if(x>1){
                         if(($(".x"+x+".y"+y).attr('value')==="") && ($(".x"+(x-1)+".y"+y).attr('value')==="")){
                                 let varClass =$(".x"+x+".y"+y).children().attr('class');
                                 let varClass2 =$(".x"+(x-1)+".y"+y).children().attr('class');
                                 if(varClass===varClass2){
                                     $(".x"+(x-1)+".y"+y).attr('value','null');
                                     $(".x"+(x-1)+".y"+y).children().remove();
                                     console.log($(".x"+x+".y"+y).attr('class'));
                                     let changeClass = parseInt($(".x"+x+".y"+y).children().attr('class').slice(1),10);
                                     changeClass +=1;
                                     let newCl = $(".x"+x+".y"+y).children().attr('class','c'+changeClass);
                                     setValue($(".x"+x+".y"+y).children());
                                 }
                         }
                     }
                 }
             }    
            }
         }
        // console.log($(".x"+x+".y"+y).children().attr('class'));
        // let varClass =$(".x"+x+".y"+y).children().attr('class');
        // let varClass2 =$(".x"+(x-1)+".y"+y).children().attr('class');
        // varClass = parseInt(varClass.slice(1));
        // varClass2 = parseInt(varClass2.slice(1));
        // if(varClass===varClass2){
        //     $(".x"+x+".y"+y).children().remove();
        //     let changeClass = parseInt($(".x"+(x-1)+".y"+y).attr('class').slice(1));
        //     changeClass ++;
        //     $(".x"+(x-1)+".y"+y).children().attr('class','c'+changeClass);
        //     setValue($(".x"+(x-1)+".y"+y).children());
        // }else move();

    }
    function setValue(td){
        let val = Math.pow(2, parseInt(td.attr('class').slice(1)),10);
        // console.log(val);
        // td.val(val);
        td.attr('value',val).html(val);
        // console.log(td.val());
    }
    $('#button').click(function(){
        location.reload();;
    });
    $(document).on("keydown",function(e) {
            switch(e.which) {
                case 37: // left
                // $("td div").animate({right: '+=130px'});
                //     console.log(e.which); 
                //     $(document).keyup();
                move("left");
                generateCell(1);
                break;
        
                case 38: // up
                move("up");
                    // console.log(e.which);
                    generateCell(1); 
                break;
        
                case 39: // right
                // $("td div").animate({right: '-=130px'});
                move("right");
                generateCell(1);
                // console.log(e.which);
                break;
        
                case 40: // down
                // $("td div").animate({bottom: '-=130px'});
                move("down");
                generateCell(1);
                // console.log(e.which);
                break;
        
                default: return;
            }
            e.preventDefault();
    });
}
