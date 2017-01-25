$(function(){
	var link = $('#base-link').text();

	$("#project").chosen().change(function() {
		var projectId 	=  $("#project").val();
		milestoneId =  $(this).val();

		$("#task option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: link+"incident-report-headers/get-tasks?project_id="+projectId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var tasks = data;

				for(var i=0; i < tasks.length; i++) {
					var option = "<option value=\"" 
					+ tasks[i].id + "\">" 
					+ tasks[i].title 
					+ "</option>";
					$("#task option:last-child").after(
						option	            	
						);
				}

				$("#task").trigger("chosen:updated");
				
			}
		});
	});	
	
	$("#task").chosen().change(function() {

		var projectId 	=  $("#project").val();
		var taskId 		=  $(this).val();


		var defaultOption = "<option value=\"\">-Select Persons Involved</option>";

		/**

			var originalCount 	= $("#persons-involved").data("count");
			var currentCount 	= $('#persons-involved').children('option').length;

		 	for (i = 0; i < currentCount ; i++) {
		 	@param  {[type]} originalCount <             i+1 [description]
		 	@return {[type]}               [description]
			if(originalCount < i+1) {
				console.log(currentCount);
				$('#persons-involved option').eq(i).remove(); 
			}
		}
		**/

		$("#persons-involved").empty();


		$("#persons-involved option:last-child").append(
			defaultOption	            	
		);


		$("#persons-involved").trigger("chosen:updated");

		$.ajax({ 
			type: "GET", 
			url: link+"incident-report-headers/get-manpower/"+projectId+"/?task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var manpower = data;

				for(var i=0; i < manpower.length; i++) {
					var option = "<option value=\""
					+ manpower[i].id + "\">" 
					+ manpower[i].name 
					+ "</option>";
					$("#persons-involved option:last-child").after(
						option	            	
					);
				}

				$("#persons-involved").trigger("chosen:updated");
				
			}
		});

	});

});