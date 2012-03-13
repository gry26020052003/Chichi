$(document).ready(function(){
	var myImages=new Array();
	var allInputs = $("#products_images input:hidden");
	for(var i=0; i<allInputs.length; i++){
		myImages.push(allInputs[i].value);
	}
	$('#current').attr({
  		src: myImages[0],
  		id:"current_0"
	});
	
	$("#next").click(function() {
  		var image = $("#products_images img");
  		var id = image[0].id;
  		var idd = id.split("_");
  		if(!(parseInt(idd[1]) >= myImages.length)){
  				idd = parseInt(idd[1])+1;
				$(image[0]).attr({
  				src: myImages[idd],
  				id:"current_" + idd
			});		
  		}
	});
	
	$("#prev").click(function() {
		var image = $("#products_images img");
  		var id = image[0].id;
  		var idd = id.split("_");
  			if(!(parseInt(idd[1]) <= 0)){
  				idd = parseInt(idd[1])-1;
				$(image[0]).attr({
  				src: myImages[idd],
  				id:"current_" + idd
			});		
  		}	
	});
	
	
	
});


