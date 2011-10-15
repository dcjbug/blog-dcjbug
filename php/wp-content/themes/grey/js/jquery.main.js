/*
	InputFocus for jQuery (version 0.9)
	Copyright (c) 2009 Simone D'Amico
	http://blog.simonedamico.com/2009/08/jquery-inputfocus-evidenziare-i-campi-input-e-textarea-di-una-form/
	
	Licensed under the MIT license:
		http://www.opensource.org/licenses/mit-license.php

	Any and all use of this script must be accompanied by this copyright/license notice in its present form.
*/
(function($){$.fn.inputfocus=function(params){params=$.extend({focus_class:"focus",value:""},params);this.each(function(){$(this).focus(function(){$(this).addClass(params.focus_class);this.value=(this.value==params.value)?'':this.value;});$(this).blur(function(){$(this).removeClass(params.focus_class);this.value=(this.value=='')?params.value:this.value;});});return this;};})(jQuery);


jQuery(document).ready(function($){

    //back to top
    jQuery("a.top").click(function() {
        jQuery("html, body").animate({scrollTop: 0},'slow');
        return false;
    });

    //open external links in other tab
    jQuery('a').each(function() {
       var a = new RegExp('/' + window.location.host + '/');
       if(!a.test(this.href)) {
           jQuery(this).click(function(event) {
               event.preventDefault();
               event.stopPropagation();
               window.open(this.href, '_blank');
           });
       }
    });
    
    //inputfocus
    jQuery('#search').inputfocus({value: "I'm searching for..."});
    jQuery('#author').inputfocus({value: "Name *"});
    jQuery('#email').inputfocus({value: "Email *"});
    jQuery('#url').inputfocus({value: "Url"});

    //show/hide comments
    jQuery('#showhide').click(function(){
        $('.commentlist').slideToggle();
        return false;
    });

});

