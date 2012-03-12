/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){

	$("#message").click(function(e){
		$(this).animate({
		    height: "75px",
		  }, 1500 );
	});
	
	
	$(".result_container #friend_list a").click(function(e){
		var type = this.id;
		if(type.indexOf("friendrequest") != -1){	
			$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/emailconfirm",
			  data:  "email="+ type,
			  success: function(msg){
				//alert(msg);
			  }
      	 	});
		}
		
		
		if(type.indexOf("inbox") != -1){
			$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/inbox",
			  data:  "inbox="+ type,
			  success: function(msg){
				alert(msg);
			  }
      	 	});
		}
	});
	
	
	$("#sub_com").click(function(){
		var $curr = $(this);		
		$curr = $curr.prev();	 
		var id = $curr.attr("id");
		var comment = $curr.attr("value");
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/test",
			  data:  "message_id="+ id +"&comment=" + comment,
			  success: function(msg){
				 alert(msg);
			  }
       });
       
       alert("adsfsf");
		
	});


	$("#msg_submit").click(function(e){
		var user = $("#publisher #current").val();
		var message = $("#message").val();
		$.ajax({
			  type: "POST",
			  url: "/chichi/public/index/message",
			  data:  "message="+ message,
			  success: function(msg){
				  $("#message_box").replaceWith('	<div style="overflow:auto; height:25px;" id="message_box">	<div style="float: left; margin-left:2.5px; font-size:1.7em;">' + user + ': </div>	<div style="float: left; margin-left:5px;">'+message+'</div>	</div>');
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