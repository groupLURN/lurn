$(function(){
	var link = $('#base-link').text();

	$('#from-project-id').chosen().change(function() {
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
		var projectId 	=  $('#from-project-id').val();
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
		var projectId 	=  $('#from-project-id').val();
		var milestoneId =  $('#milestone-id').val();
		var taskId 		=  $('#task-id').val();

		$('#equipment tr').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'/resource-request-headers/get-equipment?project_id='+projectId
				+'&milestone_id='+milestoneId
				+'&task_id='+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var equipment = data;

				for(var i=0; i < equipment.length; i++) {
					var equipmentProjectInventory = parseInt(equipment[i]['inventory-count']);
					var equipmentQuantity = parseInt(equipment[i].et.quantity) - equipmentProjectInventory;

					if(equipmentQuantity < 1) {
						equipmentQuantity = 0;
					}

					var tableRow = 
					'<tr>'
					+ '<td>'
					+ '<input type="hidden" name="equipment[id][]" value="' 
					+ equipment[i].id + '"/>' 
					+ equipment[i].name 
					+ '</td>'
					+ '<td>'
					+ equipmentProjectInventory
					+ '</td>'
					+ '<td>'
					+ '<input type="text" class="number-only" name="equipment[_joinData][][quantity]" value="' 
					+ equipmentQuantity + '"/>'
					+ '</td>'
					+ '</tr>';

					$('#equipment').append(
						tableRow	            	
					);
				}
			}
		});
	}

	function updateManpower(){
		var projectId 	=  $('#from-project-id').val();
		var milestoneId =  $('#milestone-id').val();
		var taskId 		=  $('#task-id').val();

		$('#manpower_types tr').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'/resource-request-headers/get-manpower?project_id='+projectId
				+'&milestone_id='+milestoneId
				+'&task_id='+taskId,  
			data: { get_param: 'value' }, 
			success: function (data) { 
				var manpowerTypes = data;

				for(var i=0; i < manpowerTypes.length; i++) {
					var manpowerTypeId = manpowerTypes[i].id;
					var manpowerTypeName = manpowerTypes[i].manpower_type.title;
					var manpowerTypeInventoryQuantity = parseInt(manpowerTypes[i].project_inventory_quantity);
					var manpowerTypeQuantity = parseInt(manpowerTypes[i].quantity)-manpowerTypeInventoryQuantity;
					
					if(manpowerTypeQuantity < 1) {
						manpowerTypeQuantity = 0;
					}

					var tableRow = '<tr>'+
					+ '<td>'
					+ '</td>'
					+ '<td>'
					+ '<input type="hidden" name="manpower_types[id][]"' 
					+ ' value="' + manpowerTypeId + '"/>' 
					+  manpowerTypeName
					+ '</td>'
					+ '<td>'
					+ manpowerTypeInventoryQuantity
					+ '</td>'
					+ '<td>'
					+ '<input type="type" class="number-only" name="manpower_types[_joinData][][quantity]"'
					+ ' value="' + manpowerTypeQuantity + '"/>' 
					+ '</td>'
					+ '</tr>'
					$('#manpower_types').append(
						tableRow	            	
					);
				}
			}
		});

	}

	function updateMaterials(){
		var projectId 	=  $('#from-project-id').val();
		var milestoneId =  $('#milestone-id').val();
		var taskId 		=  $('#task-id').val();

		$('#materials tr').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'/resource-request-headers/get-materials?project_id='+projectId
				+'&milestone_id='+milestoneId
				+'&task_id='+taskId,  
			data: { get_param: 'value' }, 
			success: function (data) { 
				var materials = data;

				for(var i=0; i < materials.length; i++) {
					var materialId = materials[i].id;
					var materialName = materials[i].name;
					var materialInventoryQuantity = parseInt(materials[i].mpi.quantity);
					var materialQuantity = parseInt(materials[i].mt.quantity)-materialInventoryQuantity;
					
					if(materialQuantity < 1) {
						materialQuantity = 0;
					}

					var tableRow = '<tr>'+
					+ '<td>'
					+ '</td>'
					+ '<td>'
					+ '<input type="hidden" name="materials[id][]"' 
					+ ' value="' + materialId + '"/>' 
					+  materialName
					+ '</td>'
					+ '<td>'
					+ materialInventoryQuantity
					+ '</td>'
					+ '<td>'
					+ '<input type="type" class="number-only" name="materials[_joinData][][quantity]"'
					+ ' value="' + materialQuantity + '"/>' 
					+ '</td>'
					+ '</tr>'
					$('#materials').append(
						tableRow	            	
					);
				}
			}
		});
	}

});