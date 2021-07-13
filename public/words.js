	function subcheck(){
		if(document.getElementById('word').value==''){
			alert('You must choose atleast 1 letter tile.');
			return false;
		} else {
			//document.wrdfrm.submit();	
			return true;
		}
	}


function ucFirst(charstringz){
	return charstringz.charAt(0).toUpperCase() + charstringz.substring(1);
}

$(function(){
    var tipdata = new Array();
    $('.lookup').mouseover(function(e){
        
        tipdata = $(this).attr('href').split('#');        
        $('<div id="tip"></div>').hide()
        .html("<b>"+ucFirst(tipdata[1])+"</b>:<i>  ... loading definition</i>")
               .appendTo('body')
               .load(tipdata[0] + " #" + tipdata[1] + "+dd p")
               .css({ 'top':e.pageY+10, 'left':e.pageX+20 })
               .fadeIn('fast');
    }).mousemove(function(e){
        $('#tip').css({ 'top':e.pageY+10, 'left':e.pageX+20 });
    }).mouseout(function(e){
        $('#tip').fadeOut('50000').remove();
    });
});