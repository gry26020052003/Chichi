

function appendProduct(vsg)
{
	var data = vsg.split("<br />");
	var myImages=new Array();	
	for (var prop in data){
		if((data[prop].indexOf("product") != -1)){	
				var str = data[prop].split("=");
				$("#product_title").append(str[1]);
		}else if((data[prop].indexOf("description") != -1)) {
				var str = data[prop].split("=");
				$("#product_description").append(str[1]);
		}
		else if((data[prop].indexOf("price") != -1)) {
				var str = data[prop].split("=");
				$("#product_price").append(str[1]);
		}else if((data[prop].indexOf("image") != -1)){
				var str = data[prop].split("=");
				myImages.push(str[1]);
				$("#prod_image").append('<li style="positive:absolute;"><a href="'+str[1]+'"><img src="'+str[1]+'" width="150" height="150" class="current" style="positive:absolute;"></a>');					
		}
	}	
	return myImages;
}


function inline(sel)
{
		var $curr = $(sel);	
		$curr = $curr.prev();	 
		var id = $curr.attr("id");
		var comment = $curr.attr("value");
		var current = $("#current_user").val();
		$curr = $curr.prev();	 
		var comment_id = $curr.attr("id");
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/comments",
			  data:  "message_id="+ id +"&comment=" + comment,
			  success: function(msg){
					$("#db_message_box #" + comment_id).append("<div id='comment'>"+current+": <span style='color:black;'> "+comment+" </span></div>");
			  }
       });		
}

$(document).ready(function(){
	$("#message").click(function(e){
		$(this).animate({
		    height: "75px",
		  }, 1500 );
	});
	
	
	$(".result_container #friend_list a").click(function(e){
		var type = this.id
		if(type.indexOf("friendrequest") != -1){	
			$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/emailconfirm",
			  data:  "email="+ type,
			  success: function(msg){
				alert(msg);
			  }
      	 	});
		}
		
		if(type.indexOf("inbox") != -1){	
			$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/inbox",
			  data:  "email="+ type + "&message=testing",
			  success: function(msg){
			  	alert(msg);
			  }
      	 	});
		}		
	});
	
		
	$("#product_scrapper #continue").click(function(e){
		var scrapper = $("#scrapper").val();
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/scrapper",
			  data:  "scrap=" + scrapper,
			  success: function(msg){
			  	var images = appendProduct(msg);
			  	$("#trigger_scrapper").trigger('click');
			  }
       });			
	});
	
	
	$('#saveForm').click(function(e) {
  		var title = $("#product_title").text();
  		var description = $("#product_description").text();
  		var price = $("#product_price").text();
		var link = $("#prod_image .current").attr("src");	
		var current = $("#current_user").val();
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/share",
			  data:  "product_title="+ title +"&product_description=" + description + "&product_price=" + price  + "&product_image=" + link + "&user=" + current,
			  success: function(msg){
			  }
       }); 
			
	});
	
	$("#db_message_box input:submit").click(function(e){

		var $curr = $(this);		
		$curr = $curr.prev();	 
		var id = $curr.attr("id");
		var comment = $curr.attr("value");
		var current = $("#current_user").val();
		$curr = $curr.prev();	 
		var comment_id = $curr.attr("id");
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/comments",
			  data:  "message_id="+ id +"&comment=" + comment,
			  success: function(msg){
					$("#db_message_box #" + comment_id).append("<div id='comment'>"+current+": <span style='color:black;'> "+comment+" </span></div>");
			  }
       });    
	});
	


	$("#msg_submit").click(function(e){
		var user = $("#publisher #current").val();
		var message = $("#message").val();
		var current = $("#current_user").val();
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/message",
			  data:  "message="+ message + "&user=" + current,
			  success: function(msg){
				  $("#message_box").replaceWith('<div style="overflow:auto; height:25px;" id="message_box">	<div style="float: left; margin-left:2.5px; font-size:1.7em;">' + user + ': </div>	<div style="float: left; margin-left:5px;">'+message+'</div>	</div>');
				  $("#db_message_box").prepend('<div id="leftside" style="float:left;"><img src="http://hdn.xnimg.cn/photos/hdn421/20111205/1525/h_tiny_IM0v_6f9b00029d702f76.jpg" width="50" height="50"></div>  <div id="rightside" style="margin-left: 55px;"> <span style="color:#005EAC">'+user+ ": </span>   " + message + ' <div id="comments_'+msg+'">  </div>	<textarea id="tweet_'+ msg+'" rows="2" placeholder="Leave comments"></textarea><input type="submit"  id="sub_com" value="Submit" onclick="inline(this)"/> <br /> </div> ');	
							  	
			  }
       });
	});
	
	$(".menu > li").click(function(e){
		switch(e.target.id){
			case "news":
				//change status & style menu
				$("#news").addClass("active");
				$("#tutorials").removeClass("active");
				$("#links").removeClass("active");
				//display selected division, hide others
				$("div.news").fadeIn();
				$("div.tutorials").css("display", "none");
				$("div.links").css("display", "none");
			break;
			case "tutorials":
				//change status & style menu
				$("#news").removeClass("active");
				$("#tutorials").addClass("active");
				$("#links").removeClass("active");
				//display selected division, hide others
				$("div.tutorials").fadeIn();
				$("div.news").css("display", "none");
				$("div.links").css("display", "none");
			break;
			case "links":
				//change status & style menu
				$("#news").removeClass("active");
				$("#tutorials").removeClass("active");
				$("#links").addClass("active");
				//display selected division, hide others
				$("div.links").fadeIn();
				$("div.news").css("display", "none");
				$("div.tutorials").css("display", "none");
			break;
		}
		return false;
	});
});