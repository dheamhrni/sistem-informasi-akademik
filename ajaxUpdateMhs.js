$(document).ready(function(){
	$("#searchkeyword").keyup(function(){
		var input=$(this).val()
		$.ajax({
			url: "cari.php", 
			method : "POST", 
			data : {cari:input},
			success : function(data){
				$("#hasil").html(data)
			}
		})

	})
})