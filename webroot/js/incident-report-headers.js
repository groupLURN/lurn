$(function(){
	var link = $('#base-link').text();

	$("#injured-details-header").hide();
	$("#injured-details").hide();
	$("#lost-items-details").hide();

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


		var defaultOption = "<option value=\"\">-Select Persons Involved-</option>";

		$("#persons-involved").empty();


		$("#persons-involved").append(
			defaultOption	            	
		);


		$("#persons-involved").trigger("chosen:updated");

		$.ajax({ 
			type: "GET", 
			url: link+"incident-report-headers/get-manpower/?project_id="+projectId+"&task_id="+taskId, 
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

				console.log(option);

				$("#persons-involved").trigger("chosen:updated");
				
			}
		});

	});


	$("#type").chosen().change(function() {
		var typeVal 	= $("#type").val();

		switch(typeVal) {
			case "acc":
			case "doc":
			case "inj":
				$("#injured-details-header").show();
				$("#injured-details").show();
				$("#lost-items-details").hide();
			break;
			case "los":
				$("#injured-details-header").hide();
				$("#injured-details").hide();
				$("#lost-items-details").show();
			break;
			default:
				$("#injured-details-header").hide();
				$("#injured-details").hide();
				$("#lost-items-details").hide();
		}

	});

});