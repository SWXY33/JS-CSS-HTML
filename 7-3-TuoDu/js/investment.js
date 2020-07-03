$(function(){//iframe局部刷新内容
    $("#a1").click(function(){
     var name= $(this).attr("name");
	 $("#a2").parent().removeClass("clicka1");
	 $("#a3").parent().removeClass("clicka1");
	 $(this).parent().addClass("clicka1");
     $("#iFrame").attr("src",name).ready();    
    });
    $("#a2").click(function(){
		$("#a1").parent().removeClass("clicka1");
		$("#a3").parent().removeClass("clicka1");
		$(this).parent().addClass("clicka1");
     var name= $(this).attr("name");
     $("#iFrame").attr("src",name).ready();    
    });
	$("#a3").click(function(){
	 var name= $(this).attr("name");
	 $("#a1").parent().removeClass("clicka1");
	 $("#a2").parent().removeClass("clicka1");
	 $(this).parent().addClass("clicka1");
	 $("#iFrame").attr("src",name).ready();    
	});
        });