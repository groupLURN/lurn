$(function(){
	var link = $('#base-link').text();

	$("#project-id").chosen().change(function() {
		updateEquipment();

	});


	function updateEquipment(){
		projectId 	=  $("#from-project-id").val();
		$("select[name='rental_request_details[equipment_id][]']:last option").not(":first").remove();

		$.ajax({ 
			type: "GET", 
			url: link+"/rental-request-headers/get-equipment?project_id="+projectId
				+"&milestone_id="+milestoneId
				+"&task_id="+taskId
				+"&supplier_id="+supplierId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var equipment = data;

				foreach(var i=0; i < equipment.length; i++) {

 					var obj = equipment[i];

				  	for (var key in obj){
					    var value = obj[key];

						var option = "<option value=\"" 
						+ equipment[i].id + "\">" 
						+ equipment[i].name 
						+ "</option>";
						$("#equipment").after(
							option	            	
						);
				  	}
				}

				$("#equipment").trigger("chosen:updated");
			}
		});

	}

});