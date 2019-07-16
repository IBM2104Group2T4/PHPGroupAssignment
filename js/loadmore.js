$( document ).ready(function () {
		$(".moreBox").slice(0, 5).show();
		if ($(".moreBox:hidden").length != 0) {
			$("#loadMore").show();
		}
		else {
			$("#loadMore").hide();
		}
		$("#loadMore").on('click', function (e) {
			e.preventDefault();
			$(".moreBox:hidden").slice(0, 5).slideDown();
			if ($(".moreBox:hidden").length == 0) {
				$("#loadMore").fadeOut('slow');
			}
			else{
				$("#loadMore").show();
			}		
		});
	});