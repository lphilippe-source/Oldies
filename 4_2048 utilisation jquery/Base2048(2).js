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
        if(nb===2){
            var number = 1 + Math.floor(Math.random() * 16);
            var number2 = 1 + Math.floor(Math.random() * 16);
            var x= number%4+1;
            var x2= number2%4+1;
            var y= Math.ceil(number/4);
            var y2= Math.ceil(number2/4);
            if(($("td.x"+x+".y"+y).attr('value')==="null") && ($("td.x"+x2+".y"+y2).attr('value')==="null")){
                if(x==x2 && y==y2){}
                else{
                    $(".x"+x+".y"+y).attr('value',"");//le td prend la valeur "" il a une div
                    $(".x"+x2+".y"+y2).attr('value',"");

                    $(".x"+x+".y"+y).append("<div class='c1' value=''></div>");
                    $(".x"+x2+".y"+y2).append("<div class='c1' value=''></div>")
                    let val = twoOrFour();
                    if(val===4)
                    $(".x"+x+".y"+y).children().removeClass().addClass("c2"); // si c'est 4 la classe est .2
                    let val2 = twoOrFour();
                    if(val2===4)
                    $(".x"+x2+".y"+y2).children().removeClass().addClass("c2");

                    setValue($(".x"+x+".y"+y).children());
                    setValue($(".x"+x2+".y"+y2).children());
                    
                    // $(".x"+x+".y"+y).append($(".x"+x+".y"+y).attr('value'));
                    // $(".x"+x2+".y"+y2).append($(".x"+x2+".y"+y2).attr('value'));
                    return;
                }
            }
        }
        if(nb===1 || nb===0){
            // if(($("td.x"+x+".y"+y).attr('value')==="null") {
                var number = 1 + Math.floor(Math.random() * 16);
                var x= number%4+1;
                var y= Math.ceil(number/4);
                if(($(".x"+x+".y"+y).attr('value')==="null")){
                    $(".x"+x+".y"+y).attr('value',"");
                    $(".x"+x+".y"+y).append("<div class='c1' value=''></div>");
                    let val = twoOrFour();
                    if(val===4)
                    $(".x"+x+".y"+y).children().removeClass().addClass("c2");

                    setValue($(".x"+x+".y"+y).children());
                    // div= $(".x"+x+".y"+y).append("2");
                    return;
                }
            
        }
        generateCell(nb);
    }
    function move(){
        for(y=1;y<5;y++){
            for(x=2;x<5;x++){
                console.log($("td.x"+x+".y"+y).children().attr('class'));
                console.log($("td.x"+x+".y"+y).children().attr('value'));
                if(($("td.x"+(x-1)+".y"+y).attr('value')==="null")&&($("td.x"+x+".y"+y).attr('value')==="")){
                    $("td.x"+x+".y"+y).children().animate({bottom: '+=130px'});
                    $("td.x"+(x-1)+".y"+y).attr('value',"");
                    $("td.x"+(x)+".y"+y).attr('value',"null");
                    // if($("td.x"+x+".y"+y).children().attr('value')!=undefined){
                    //     mergeItem(x,y);
                    // }
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
                $("td div").animate({right: '+=130px'});
                    console.log(e.which); 
                    $(document).keyup();
                break;
        
                case 38: // up
                move();
                    console.log(e.which); 
                break;
        
                case 39: // right
                $("td div").animate({right: '-=130px'});
                console.log(e.which);
                break;
        
                case 40: // down
                $("td div").animate({bottom: '-=130px'});
                console.log(e.which);
                break;
        
                default: return;
            }
            e.preventDefault();
    });
}
