$(function(){
	var link = $('#base-link').text();

	$("#project-id").chosen().change(function() {
		projectId =  $(this).val();

		updateSuppliers();

		$("#milestone-id option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: link+"purchase-order-headers/get-milestones?project_id="+projectId, 
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
			url: link+"purchase-order-headers/get-tasks?project_id="+projectId+"&milestone_id="+milestoneId, 
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
		updateMaterials();
	});

	function updateSuppliers() {
		projectId 	=  $("#project-id").val();
		milestoneId =  $("#milestone-id").val();
		taskId 		=  $("#task-id").val();

		$("#supplier-id option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: link+"purchase-order-headers/get-suppliers?project_id="+projectId+"&milestone_id="+milestoneId+"&task_id="+taskId, 
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

	function updateMaterials(){
		projectId 	=  $("#project-id").val();
		milestoneId =  $("#milestone-id").val();
		taskId 		=  $("#task-id").val();
		supplierId 	=  $("#supplier-id").val();

		$("select[name='purchase_order_details[material_id][]']:last option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: link+"purchase-order-headers/get-materials?project_id="+projectId
				+"&milestone_id="+milestoneId
				+"&task_id="+taskId
				+"&supplier_id="+supplierId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var materials = data;

				for(var i=0; i < materials.length; i++) {
					var option = "<option value=\"" 
					+ materials[i].id + "\">" 
					+ materials[i].name 
					+ "</option>";
					$("select[name='purchase_order_details[material_id][]']:last option:last").after(
						option	            	
						);
				}

				$("select[name='purchase_order_details[material_id][]']:last").trigger("chosen:updated");
			}
		});

	}

});