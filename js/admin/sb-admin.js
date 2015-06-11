/*
 * metismenu - v1.0.3
 * Easy menu jQuery plugin for Twitter Bootstrap 3
 * https://github.com/onokumus/metisMenu
 *
 * Made by Osman Nuri Okumuş
 * Under MIT License
 */
!function(a,b,c){function d(b,c){this.element=b,this.settings=a.extend({},f,c),this._defaults=f,this._name=e,this.init()}var e="metisMenu",f={toggle:!0};d.prototype={init:function(){var b=a(this.element),c=this.settings.toggle;this.isIE()<=9?(b.find("li.active").has("ul").children("ul").collapse("show"),b.find("li").not(".active").has("ul").children("ul").collapse("hide")):(b.find("li.active").has("ul").children("ul").addClass("collapse in"),b.find("li").not(".active").has("ul").children("ul").addClass("collapse")),b.find("li").has("ul").children("a").on("click",function(b){b.preventDefault(),a(this).parent("li").toggleClass("active").children("ul").collapse("toggle"),c&&a(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide")})},isIE:function(){for(var a,b=3,d=c.createElement("div"),e=d.getElementsByTagName("i");d.innerHTML="<!--[if gt IE "+ ++b+"]><i></i><![endif]-->",e[0];)return b>4?b:a}},a.fn[e]=function(b){return this.each(function(){a.data(this,"plugin_"+e)||a.data(this,"plugin_"+e,new d(this,b))})}}(jQuery,window,document);

$(document).ready(function() {
	//$(function() {

		$('#side-menu').metisMenu();

	//});

	//Loads the correct sidebar on window load,
	//collapses the sidebar on window resize.
	// Sets the min-height of #page-wrapper to window size
	//$(function() {
		$(window).bind("load resize", function() {
			topOffset = 50;
			width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
			if (width < 768) {
				$('div.navbar-collapse').addClass('collapse');
				topOffset = 100; // 2-row-menu
			} else {
				$('div.navbar-collapse').removeClass('collapse');
			}

			height = (this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height;
			height = height - topOffset;
			if (height < 1) height = 1;
			if (height > topOffset) {
				$("#page-wrapper").css("min-height", (height) + "px");
			}
		});
	//});
    
    //--------------------------------------------------
    $(".deletelink").click(function(e) {
        e.preventDefault();
        if(confirm("Confirmaci\u00F3n para Eliminar")) {
            window.location = $(this).attr("href");
        } else {
            return false;
        }
    });
    
    $(".confirm-leave").click(function(e) {
        e.preventDefault();
        if(confirm("Confirmaci\u00F3n para salir")) {
            window.location = $(this).attr("href");
        } else {
            return false;
        }
    });
    
    //--------------------------------------------------
    $(".deleteform").click(function() {
        if(!confirm("Confirmaci\u00F3n para Eliminar")) {
            return false;
        }
        var form = $(this).attr("data-deleteform");
        $("#" + form).submit();
    });
    
    //---------------------------------------------------
    $("#loadtrigger").submit(function() {
        $(".ajax-loader-bg").fadeIn();
    });
    
    //---------------------------------------------------
    if(document.getElementById("full_content")) {
        CKEDITOR.replace('content', {
            language: 'es',
            contentsCss : ['../css/public/bootstrap/bootstrap.min.css']
        });
    }
    
    if(document.getElementById("simple_content")) {
        CKEDITOR.replace('content', {
            language: 'es',
            contentsCss : ['../css/public/bootstrap/bootstrap.min.css'],
            /*
            toolbar: [
                [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ],																				// Line break - next group will be placed in new line.
                [ 'Bold', 'Italic', 'Underline', 'Format', 'Font', 'FontSize','TextColor', 'BGColor' ]
            ],
            */
            height: 600
        });
    }
});