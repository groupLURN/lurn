$(function(){
	var link = $('#base-link').text();

	$("#injured-details-header").hide();
	$("#injured-details").hide();
	$("#items-lost-details").hide();

	$("#project-id").chosen().change(function() {
		var projectId 	=  $("#project-id").val();
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

		var projectId 	= $("#project-id").val();
		var taskId 		= $(this).val();	

		$("#person-list option").not(":first").remove();

		$("#person-list").trigger("chosen:updated");

		$.ajax({ 
			type: "GET", 
			url: link+"incident-report-headers/get-persons/?project_id="+projectId+"&task_id="+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var persons = data;

				for(var i=0; i < persons.length; i++) {
					var option = "<option value=\""
					+ persons[i].id + "\""
					+ " data-address=\""
					+ persons[i].address + "\""
					+ " data-age=\""
					+ persons[i].age + "\""
					+ " data-contact=\""
					+ persons[i].contact + "\""
					+ " data-occupation=\""
					+ persons[i].occupation + "\""
					+">" 
					+ persons[i].name 
					+ "</option>";
					$("#person-list option:last-child").after(
						option	            	
						);
				}

				$("#person-list").trigger("chosen:updated");
				
			}
		});


		updateItemList();
	});


	$("#type").chosen().change(function() {
		var type	= $("#type").val();

		switch(type) {
			case "acc":
			case "doc":
			case "inj":
				$("#injured-details-header").show();
				$("#injured-details").show();
				$("#items-lost-details").hide();
				$("#items-lost-details input").each().prop("disabled", true);
			break;
			case "los":
				$("#injured-details-header").hide();
				$("#injured-details").hide();
				$("#items-lost-details").show();
				$("#items-lost-details input").each().prop("disabled", false);

				updateItemList();
			break;
			default:
				$("#injured-details-header").hide();
				$("#injured-details").hide();
				$("#items-lost-details").hide();
				$("#items-lost-details input").each().prop("disabled", true);
		}

	});

	$("#person-list").chosen().change(function(){	
		var $context		= $("#person-list option:selected");
		var selectedIndex	= $($context).index();
		var type     		= $("#type").val();        	

		switch(type) {
			case "acc":
			case "doc":
			case "inj":
			if(selectedIndex != 0){
				var userName    	= $($context).text();
				var userAddress		= $($context).data("address");
				var userAge    		= $($context).data("age");
				var userContact   	= $($context).data("contact");
				var userOccupation	= $($context).data("occupation");

				$("#injured-name").val(userName);
				$("#injured-address").val(userAddress);
				$("#injured-age").val(userAge);
				$("#injured-contact").val(userContact);
				$("#injured-occupation").val(userOccupation);
			} else {
				resetInjuredInput();
			}
			break;
		}

	});

	function updateItemList(){
		var taskId 		= $("#task").val();	
		var type		= $("#type").val();

		if(taskId != 0 && type == "los") {

			$("#item-list option").not(":first").remove();

			$.ajax({ 
				type: "GET", 
				url: link+"incident-report-headers/get-items/?task_id="+taskId, 
				data: { get_param: 'value' }, 
				success: function (data) { 
					var items = data;

					for(var i=0; i < items.length; i++) {
						var option = "<option value=\""
						+ items[i] + "\""
						+">" 
						+ items[i]
						+ "</option>";
						$("#item-list option:last-child").after(
							option	            	
							);
					}

					$("#item-list").trigger("chosen:updated");
					
				}
			});
		}
	}

});