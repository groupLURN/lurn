$(function(){
	var link = $('#base-link').text();

	$('#project-id').chosen().change(function() {
		projectId =  $(this).val();

		updateSuppliers();

		$('#milestone-id option').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'rental-request-headers/get-milestones?project_id='+projectId, 
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
		projectId 	=  $('#project-id').val();
		milestoneId =  $(this).val();

		updateSuppliers();

		$('#task-id option').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'rental-request-headers/get-tasks?project_id='+projectId+'&milestone_id='+milestoneId, 
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
		updateSuppliers();
	});

	$('#supplier-id').chosen().change(function() {
		updateEquipment();
	});

	$('#rental-request-add').on('click', '.remove-equipment', function() {
		$(this).closest('tr').remove();
	});

	function updateSuppliers() {
		projectId 	=  $('#project-id').val();
		milestoneId =  $('#milestone-id').val();
		taskId 		=  $('#task-id').val();

		$('#supplier-id option').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'rental-request-headers/get-suppliers?project_id='+projectId+'&milestone_id='+milestoneId+'&task_id='+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var suppliers = data;

				for(var i=0; i < suppliers.length; i++) {
					var option = '<option value="' 
					+ suppliers[i].id + '">' 
					+ suppliers[i].name 
					+ '</option>';
					$('#supplier-id option:last-child').after(
						option	            	
						);
				}

				$('#supplier-id').trigger('chosen:updated');
			}
		});

	}

	function updateEquipment(){
		projectId 	=  $('#project-id').val();
		milestoneId =  $('#milestone-id').val();
		taskId 		=  $('#task-id').val();
		supplierId 	=  $('#supplier-id').val();

		$('#rental-request-add tr').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'rental-request-headers/get-equipment?project_id='+projectId
				+'&milestone_id='+milestoneId
				+'&task_id='+taskId
				+'&supplier_id='+supplierId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var equipment = data;

				for(var i=0; i < equipment.length; i++) {
					var equipmentId 				= equipment[i].id;
					var equipmentName 				= equipment[i].name;
					var equipmentQuantity			= 0;
					var equipmentQuantityNeeded		= parseInt(equipment[i].et.quantity);
					var equipmentInventoryQuantity 	= parseInt(equipment[i]['general-inventory-count']);
					
					if(typeof equipmentInventoryQuantity == 'undefined' 
						|| equipmentInventoryQuantity < equipmentQuantityNeeded) {
						equipmentQuantity = equipmentQuantityNeeded-equipmentInventoryQuantity;
					}

					var tableRow = '<tr>'
					+ '<td>'
					+ '<input type="hidden" name="rental_request_details[equipment_id][]"'
					+ 'value="' + equipmentId + '">'
					+ equipmentName
					+ '</td>'
					+ '<td>'
					+ equipmentInventoryQuantity
					+ '</td>'
					+ '<td>'
					+ equipmentQuantityNeeded
					+ '</td>'
					+ '<td>'
					+ '<input type="text" class="number-only" name="rental_request_details[quantity][]"'
					+ 'value="' + equipmentQuantity + '">'
					+ '</td>'
					+ '<td>'
					+ '<input type="text" class="number-only" name="rental_request_details[duration][]">'
					+ '</td>'
					+ '<td>'
					+ '<button class="btn remove-equipment" type="button">Remove</button>'
					+ '</td>'
					+ '</tr>';

					$('#rental-request-add').append(
						tableRow	            	
					);
				}
			}
		});

	}

});