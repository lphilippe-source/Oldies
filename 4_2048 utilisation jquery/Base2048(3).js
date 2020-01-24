$.fn.game2048 = function()
{
    this.append(generateMap());
    function generateMap(){
        let table = $("<table></table>");
        for(j=1;j<5;j++){
            table.append("<tr></tr>");
            for(i=1;i<5;i++){
                table.find("tr:last").append("<td class='x"+i+" "+"y"+j+"' value='null'></td>");
            }
        }
        return table;                         
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
                for(let i=0;i<nb;i++){
                number = 1 + Math.floor(Math.random() * 16);
                x= number%4+1;
                y= Math.ceil(number/4);
                    if(($(".x"+x+".y"+y).attr('value')==="null")){
                        $(".x"+x+".y"+y).attr('value',"");
                        $(".x"+x+".y"+y).append("<div class='c1' value=''></div>");
                        let val = twoOrFour();
                        if(val===4)
                        $(".x"+x+".y"+y).children().removeClass().addClass("c2");

                        setValue($(".x"+x+".y"+y).children());
                        // div= $(".x"+x+".y"+y).append("2");
                    }else
                    generateCell((i));
                }
        // generateCell(nb);
    }
    function move(key){
        for(y=1;y<5;y++){
            for(x=1;x<5;x++){
                console.log($(".x"+x+".y"+y).children().attr('class'));
                console.log($(".x"+x+".y"+y).children().attr('value'));
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
                }
                if(key==="up"){
                    if(y>=1){
                        movefaster(y);
                        function movefaster(y){
                            if(($(".x"+x+".y"+(y-1)).attr('value')==="null")&&($(".x"+x+".y"+y).attr('value')==="")){
                                let divMove = $(".x"+x+".y"+y).children().detach();
                                $(".x"+x+".y"+(y-1)).attr('value',"");
                                divMove.appendTo($(".x"+x+".y"+(y-1)));
                                $(".x"+(x)+".y"+y).attr('value',"null");
                                movefaster((y-1));
                            }
                        }
                    }
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
                }
                
                if(key==="down"){
                    
                        movefaster(y);
                        function movefaster(y){
                            if(y<=3){
                                if(($(".x"+x+".y"+(y+1)).attr('value')==="null")&&($(".x"+x+".y"+y).attr('value')==="")){
                                    let divMove = $(".x"+x+".y"+y).children().detach();
                                    $(".x"+x+".y"+(y+1)).attr('value',"");
                                    divMove.appendTo($(".x"+x+".y"+(y+1)));
                                    $(".x"+(x)+".y"+y).attr('value',"null");
                                    movefaster((y+1));
                                }
                            }
                            
                        }
                }
                // else mergeItem(x,y);
            }
        }
    }
    function mergeItem(x,y){
        console.log($("td.x"+x+".y"+y).children().attr('class'));
        let varClass =$("td.x"+x+".y"+y).children().attr('class');
        let varClass2 =$("td.x"+(x-1)+".y"+y).children().attr('class');
        varClass = parseInt(varClass.slice(1));
        varClass2 = parseInt(varClass2.slice(1));
        if(varClass===varClass2){
            $("td.x"+x+".y"+y).children().remove();
            let changeClass = parseInt($("td.x"+(x-1)+".y"+y).attr('class').slice(1));
            changeClass ++;
            $("td.x"+(x-1)+".y"+y).children().attr('class','c'+changeClass);
            setValue($("td.x"+(x-1)+".y"+y).children());
        }else move();

    }
    function setValue(td){
        let val = Math.pow(2, parseInt(td.attr('class').slice(1)));
        console.log(val);
        // td.val(val);
        td.attr('value',val).html(val);
        // console.log(td.val());
    }
    $(document).on("keydown",function(e) {
            switch(e.which) {
                case 37: // left
                // $("td div").animate({right: '+=130px'});
                //     console.log(e.which); 
                //     $(document).keyup();
                move("left");
                break;
        
                case 38: // up
                move("up");
                    console.log(e.which); 
                break;
        
                case 39: // right
                // $("td div").animate({right: '-=130px'});
                move("right");
                generateCell(1);
                console.log(e.which);
                break;
        
                case 40: // down
                // $("td div").animate({bottom: '-=130px'});
                move("down");
                generateCell(1);
                console.log(e.which);
                break;
        
                default: return;
            }
            e.preventDefault();
    });
}
