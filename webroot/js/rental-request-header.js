$(function(){

	$("#project-id").chosen().change(function() {
		projectId =  $(this).val();

		updateSuppliers();

		$("#milestone-id option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: "http://localhost/projects/lurn/rental-request-headers/get-milestones?project_id="+projectId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var milestones = data;

				for(var i=0; i < milestones.length; i++) {
					var option = "<option value=\"" 
					+ milestones[i].id + "\">" 
					+ milestones[i].title 
					+ "</option>";
					$("#milestone-id option:last-child").after(
						option	            	
						);
				}

				$("#milestone-id").trigger("chosen:updated");
				
			}
		});

	});

	$("#milestone-id").chosen().change(function() {
		projectId 	=  $("#project-id").val();
		milestoneId =  $(this).val();

		updateSuppliers();

		$("#task-id option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: "http://localhost/projects/lurn/rental-request-headers/get-tasks?project_id="+projectId+"&milestone_id="+milestoneId, 
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

	$("#task-id").chosen().change(function() {
		updateSuppliers();
	});

	$("#supplier-id").chosen().change(function() {
		updateEquipment();
	});

	function updateSuppliers() {
		projectId 	=  $("#project-id").val();
		milestoneId =  $("#milestone-id").val();
		taskId 		=  $("#task-id").val();

		$("#supplier-id option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: "http://localhost/projects/lurn/rental-request-headers/get-suppliers?project_id="+projectId+"&milestone_id="+milestoneId+"&task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var suppliers = data;

				for(var i=0; i < suppliers.length; i++) {
					var option = "<option value=\"" 
					+ suppliers[i].id + "\">" 
					+ suppliers[i].name 
					+ "</option>";
					$("#supplier-id option:last-child").after(
						option	            	
						);
				}

				$("#supplier-id").trigger("chosen:updated");
			}
		});

	}

	function updateEquipment(){
		projectId 	=  $("#project-id").val();
		milestoneId =  $("#milestone-id").val();
		taskId 		=  $("#task-id").val();
		supplierId 	=  $("#supplier-id").val();
		//rental_request_details[equipment_id][]
		$("select[name='rental_request_details[equipment_id][]']:last option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: "http://localhost/projects/lurn/rental-request-headers/get-equipment?project_id="+projectId
				+"&milestone_id="+milestoneId
				+"&task_id="+taskId
				+"&supplier_id="+supplierId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var equipment = data;

				for(var i=0; i < equipment.length; i++) {
					var option = "<option value=\"" 
					+ equipment[i].id + "\">" 
					+ equipment[i].name 
					+ "</option>";
					$("select[name='rental_request_details[equipment_id][]']:last option:last").after(
						option	            	
						);
				}

				$("select[name='rental_request_details[equipment_id][]']:last").trigger("chosen:updated");
			}
		});

	}

});