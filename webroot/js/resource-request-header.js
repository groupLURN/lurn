$(function(){
	var link = $('#base-link').text();

	$("#from-project-id").chosen().change(function() {
		var projectId 	=  $(this).val();

		updateEquipment();
		updateManpower();
		updateMaterials();
		$('#milestone-id option').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'purchase-order-headers/get-milestones?project_id='+projectId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var milestones = data;

				for(var i=0; i < milestones.length; i++) {
					var option = '<option value="' 
					+ milestones[i].id + '">' 
					+ milestones[i].title 
					+ '</option>';
					$('#milestone-id option:last-child').after(
						option	            	
						);
				}

				$('#milestone-id').trigger('chosen:updated');				
			}
		});

	});

	$('#milestone-id').chosen().change(function() {
		var projectId 	=  $("#from-project-id").val();
		var milestoneId =  $(this).val();

		updateEquipment();
		updateManpower();
		updateMaterials();

		$('#task-id option').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'purchase-order-headers/get-tasks?project_id='+projectId+'&milestone_id='+milestoneId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var tasks = data;

				for(var i=0; i < tasks.length; i++) {
					var option = '<option value="' 
					+ tasks[i].id + '">' 
					+ tasks[i].title 
					+ '</option>';
					$('#task-id option:last-child').after(
						option	            	
						);
				}

				$('#task-id').trigger('chosen:updated');				
			}
		});
	});

	$('#task-id').chosen().change(function() {
		updateEquipment();
		updateManpower();
		updateMaterials();
	});

	function updateEquipment(){
		var projectId 	=  $("#from-project-id").val();
		var milestoneId =  $('#milestone-id').val();
		var taskId 		=  $('#task-id').val();

		$('#equipment-list option').not(':first').remove();

		$.ajax({ 
			type: "GET", 
			url: link+"/resource-request-headers/get-equipment?project_id="+projectId
				+"&milestone_id="+milestoneId
				+"&task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var equipment = data;

				for(var i=0; i < equipment.length; i++) {
					var option = "<option value=\"" 
					+ equipment[i].id + "\">" 
					+ equipment[i].name 
					+ "</option>";
					$("#equipment-list").append(
						option	            	
					);
				}

				$("#equipment-list").trigger("chosen:updated");
			}
		});
	}

	function updateManpower(){
		var projectId 	=  $("#from-project-id").val();
		var milestoneId =  $('#milestone-id').val();
		var taskId 		=  $('#task-id').val();

		$('#manpower-list option').not(':first').remove();

		$.ajax({ 
			type: "GET", 
			url: link+"/resource-request-headers/get-manpower?project_id="+projectId
				+"&milestone_id="+milestoneId
				+"&task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var manpower = data;

				for(var i=0; i < manpower.length; i++) {
					var option = "<option value=\"" 
					+ manpower[i].manpower_type_id + "\">" 
					+ manpower[i].manpower_type.title 
					+ "</option>";
					$("#manpower-list").append(
						option	            	
					);
				}

				$("#manpower-list").trigger("chosen:updated");
			}
		});

	}

	function updateMaterials(){
		var projectId 	=  $("#from-project-id").val();
		var milestoneId =  $('#milestone-id').val();
		var taskId 		=  $('#task-id').val();

		$('#materials-list option ').not(':first').remove();

		$.ajax({ 
			type: "GET", 
			url: link+"/resource-request-headers/get-materials?project_id="+projectId
				+"&milestone_id="+milestoneId
				+"&task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var materials = data;

				for(var i=0; i < materials.length; i++) {
					var option = "<option value=\"" 
					+ materials[i].id + "\">" 
					+ materials[i].name 
					+ "</option>";
					$("#materials-list").append(
						option	            	
					);
				}

				$("#materials-list").trigger("chosen:updated");
			}
		});
	}

});