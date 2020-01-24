/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$(document).ready(function(){

    $("#scroll-up-button").hover(function() { //scrolltop
        $(".cont").animate({
            scrollTop: $(".cont").offset().top -50
        }, 10000)},function(){ $(".cont").stop()}
    );

    $("#scroll-down-button").hover(function() { //scrolldown
        var n = $( ".card" ).length;
        var bottom = (n*($(".card").height()+400)) - ($(window).height());
        console.log(n*($(".card").height()));
        console.log($(window).height());
        $(".cont").animate({

            scrollTop: bottom
        }, 10000)},function(){ $(".cont").stop()}
    );

    $(".close").on("click", function(){
        $(this).parent().parent().remove();
    });

    $(".imgclic").on("click", function(){
    var title = $(this).prev().find('.card-title').data('title');
    var overview = $(this).next().find('.ct').data('overview');
    $(".favorite").css("visibility","visible");
    var id=$('.card-title').data('id');
    $('#addfav').attr("name",id);
    // $(".favorite").attr();
    console.log(title);
    $("#div_content").html("<div class='jumbotron'><h1 class='display-3'>"+title+"</h1><p class='lead'>"+overview+"</p><hr class='my-4'><p></p><p class='lead'><a class='btn btn-primary btn-lg' href='#' role='button'>Learn more</a></p></div>");
    });

    $('.favorite').submit(function(){
    var id=$('addfav').val();
    $.post('/ajax',{name:id},function(donnees){

    })

    })


});


console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

