$(function(){
	var link = $('#base-link').text();
	var projectId =  $('#project-id').text();


	$("#project").chosen().change(function() {
		projectId 	=  $("#project").val();
		milestoneId =  $(this).val();

		updateSuppliers();

		$("#task-id option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: link+"rental-request-headers/get-tasks?project_id="+projectId+"&milestone_id="+milestoneId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var tasks = data;

				for(var i=0; i < tasks.length; i++) {
					var option = "<option value=\"" 
					+ tasks[i].id + "\">" 
					+ tasks[i].title 
					+ "</option>";
					$("#task-id option:last-child").after(
						option	            	
						);
				}

				$("#task-id").trigger("chosen:updated");
				
			}
		});
	});	



	$("#task").chosen().change(function() {
		var taskId =  $(this).val();

		var originalCount = $("#involved-personnel").data("count");

		var currentCount = $('#involved-personnel').children('option').length;

		for (i = 0; i < currentCount ; i++) {
			if(originalCount < i+1) {
					console.log(currentCount);
				$('#involved-personnel option').eq(i).remove(); 
			}
		}
		$("#involved-personnel").trigger("chosen:updated");

		$.ajax({ 
			type: "GET", 
			url: link+"incident-report-headers/get-manpower/"+projectId+"/?task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var manpower = data;

				for(var i=0; i < manpower.length; i++) {
					var option = "<option value=\"manpower-" 
					+ manpower[i].id + "\">" 
					+ manpower[i].name 
					+ "</option>";
					$("#involved-personnel option:last-child").after(
						option	            	
						);
				}

				$("#involved-personnel").trigger("chosen:updated");
				
			}
		});

	});



});