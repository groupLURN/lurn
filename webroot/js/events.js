$(function(){
	var baseLink = $('#base-link').text();

	$(document).on("click", ".day", function () {
		var day 		= $(this).data("day");
		var updates 	= $(this).data("updates");
		var dueProjects = $(this).data("due-projects");
		var dueProjectsIds = $(this).data("due-projects-id");

		console.log($(this).data("due-projects"));
		$(".modal-title .modal-day").text(day);  

		if (typeof updates != 'undefined') {
			$(".modal-body .modal-updates").show(); 
			$(".modal-body .modal-updates-list li").remove();  
			for(var i = 0;i < updates.length;i++) {	
				$(".modal-body .modal-updates-list").append("<li>" + updates[i] + "</li>");  
			}
		} else {
			$(".modal-body .modal-updates").hide(); 
		}

		if (typeof dueProjects != 'undefined') {
			$(".modal-body .modal-due-projects").show();
			$(".modal-body .modal-due-projects-list li").remove();  


			for(var i = 0;i < dueProjects.length;i++) {	
				var link = baseLink+"projects/view/"+dueProjectsIds[i];		
				$(".modal-body .modal-due-projects-list").append("<li><a href=\"" + link + "\">" + dueProjects[i] + "</a></li>");  
			}
		} else {			
			$(".modal-body .modal-due-projects").hide(); 
		}

	});

});