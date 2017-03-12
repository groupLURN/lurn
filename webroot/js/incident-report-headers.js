$(function(){
	var link = $('#base-link').text();

	$('#injured-details-header').hide();
	$('#injured-details').hide();
	$('#items-lost-details').hide();

	window.addEventListener ? 
	window.addEventListener("load", initialize(), false) : 
	window.attachEvent && window.attachEvent("onload", initialize());

	$('#project-id').change(function() {
		var projectId 		= $('#project-id').val();
		var projectName		= $('#project-id option:selected').text();
		var projectEngineer = $('#project-id option:selected').data('project-engineer');
		var location 		= $('#project-id option:selected').data('location');
		var oldProjectId	= $('#project-id ').data('old-project');	

		$('#project-engineer').val(projectEngineer);
		$('#project-location').val(location);

		var flag = true;

		if(oldProjectId != '' && oldProjectId != projectId) {
			var confirmMessage = 'Changing the project to ' + projectName + ' would reset the inputs below. Do you want to continue?'
			if(!confirm(confirmMessage)) {
				$('#project-id option[value="' + oldProjectId + '"]').prop('selected', true);
				$('#project-id').trigger('chosen:updated');
				flag = false;
			}
		}

		if(flag) {
			resetPersonsInvolved();
			resetItemsLost();

			$('#project-id').data('old-project', projectId);
			updateTasks();			
			updatePersonList();
		}
	});	
	
	$('#task').change(function() {
		var taskId 			= $('#task').val();	
		var taskName 		= $('#task option:selected').text();	
		var oldTaskId 		= $('#task').data('old-task');	

		var flag = true;

		if(oldTaskId != '' && oldTaskId != taskId) {
			var confirmMessage = 'Changing the task to ' + taskName + ' would reset the inputs below. Do you want to continue?'
			if(!confirm(confirmMessage)) {
				$('#task option[value="' + oldTaskId + '"]').prop('selected', true);
				$('#task').trigger('chosen:updated');
				flag = false;
			}
		}

		if(flag) {
			resetPersonsInvolved();
			resetItemsLost();

			updatePersonList();
			updateItemList();

			$('#task').data('old-task', taskId);
		}
	});

	$('#type').chosen().change(function() {
		displayProperInput();
	});

	$('#person-list').change(function(){	
		var $context		= $('#person-list option:selected');
		var selectedIndex	= $($context).index();
		var type     		= $('#type').val();        	

		switch(type) {
			case 'acc':
			case 'doc':
			case 'inj':
			if(selectedIndex != 0){
				var personName    	= $($context).text();
				var personAddress		= $($context).data('address');
				var personAge    		= $($context).data('age');
				var personContact   	= $($context).data('contact');
				var personOccupation	= $($context).data('occupation');

				$('#injured-name').val(personName);
				$('#injured-address').val(personAddress);
				$('#injured-age').val(personAge);
				$('#injured-contact').val(personContact);
				$('#injured-occupation').val(personOccupation);
			} else {
				clearInjuredInput();
			}
			break;
		}

	});

	$('#add-involved').on('click', function() {
		var $context        = $('#person-list option:selected');
		var personId          = $('#person-list').val();
		var personName        = $($context).text(); 

		if(personId != '') {
			var type     = $('#type').val();

			if(type == '') {
				alert('Please select an incident type first.');

				return 0;
			} 


			var personSummary = $('#injured-summary').val();

			appendInvolved(personId, personName, personSummary, type);
		}

	});

	$('#add-item').on('click', function() {
		var type     = $('#type').val();

		if(type == '') {
			alert('Please select an incident type first.');

			return 0;
		} 

		switch(type) {
			case 'los':

			var itemId          = $('#item-list').val();
			var itemName        = $('#item-list option:selected').text();
			var itemQuantity    = $('#item-quantity').val();

			if(itemQuantity == '') {
				alert('Please add an item quantity.');

				return 0;
			} 

			if(itemId != '') {
				appendItem(itemId, itemName, itemQuantity);
			}
			break;
		}

	});

	$('#persons-involved').on('click', '.remove-involved', function() {        
		var $context        = $(this).closest('li');
		var personId          = $($context).data('id');
		var personName        = $($context).data('name');

		var confirmMessage = 'Are you sure you want to remove ' + personName + ' from involved persons?'
		if(confirm(confirmMessage)) {

			$('#person-list option[value="' + personId + '"]').prop('disabled', false);

			$('#person-list').trigger('chosen:updated');

			$($context).remove();

			if($('#persons-involved li').length < 1) {
				$('#persons-involved').html('None.');
			}

		}
	});


	$('#items-lost').on('click', '.remove-item', function() {        
		var $context        = $(this).closest('li');
		var itemId          = $($context).data('id');
		var itemName        = $($context).data('name');

		var confirmMessage = 'Are you sure you want to remove ' + itemName + ' from lost items?'

		if(confirm(confirmMessage)) {
			var option = '<option value="'
			+ itemId + '"'
			+'>' 
			+ itemName
			+ '</option>';

			$('#item-list option[value="' + itemId + '"]').prop('disabled', false);

			$('#item-list').trigger('chosen:updated');

			$($context).remove();

			if($('#items-lost li').length < 1) {
				$('#items-lost').html('None.');
			}

		}
	});

	function initialize() {

		var projectEngineer = $('#project-id option:selected').data('project-engineer');
		var location 		= $('#project-id option:selected').data('location');

		resetPersonsInvolved();
		resetItemsLost();

		updatePersonList();
		updateItemList();
		updateTasks();

		$('#project-engineer').val(projectEngineer);
		$('#project-location').val(location);
	
		var action = window.location.pathname.split("/").pop();
		if (action == 'edit') {
			populateEditData();
		}

		displayProperInput();

	}

	function displayProperInput(){

		var type	= $('#type').val();
		var oldType	= $('#type').data('old-type');

		var confirmMessage = 'Changing the incident type to ' + $('#type option:selected').text() + ' would change the input fields below.'
		+ ' Also, involved persons will be reset.'
		+ ' Do you want to continue?'

		switch(type) {
			case 'acc':
			case 'doc':
			case 'inj':
			var flag = true;
			if(oldType != 'acc' && oldType != 'doc' && oldType != 'inj' && oldType != '') {		
				if(!confirm(confirmMessage)){
					$('#type option[value="' + oldType + '"]').prop('selected', true);
					$('#type').trigger('chosen:updated');
					flag = false;
				} else {						
					resetPersonsInvolved();
					resetItemsLost();

					updatePersonList();
				}
			} 

			if(flag) {	
				$('#type').data('old-type', type);

				$('#injured-details-header').show();
				$('#injured-details').show();
				$('#items-lost-details').hide();
				$('#items-lost input').prop('disabled', true);		
			}

			break;
			case 'los':
			var flag = true;
			if(oldType != 'los' && oldType != '') {				
				if(!confirm(confirmMessage)){
					$('#type option[value="' + oldType + '"]').prop('selected', true);
					$('#type').trigger('chosen:updated');
					flag = false;
				} else {						
					resetPersonsInvolved();

					updatePersonList();
				}
			}

			if(flag) {	
				$('#type').data('old-type', type);

				$('#injured-details-header').hide();
				$('#injured-details').hide();
				$('#items-lost-details').show();
				$('#items-lost input').prop('disabled', false);

				updateItemList();	
			}
			break;
			default:
			$('#injured-details-header').hide();
			$('#injured-details').hide();
			$('#items-lost-details').hide();
			$('#items-lost input').prop('disabled', true);
		}

	}

	function updateTasks() {
		var projectId 		= $('#project-id').val();

		$('#task option').not(':first').remove();

		$.ajax({ 
			type: 'GET', 
			url: link+'incident-report-headers/get-tasks?project_id='+projectId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var tasks = data;

				for(var i=0; i < tasks.length; i++) {
					var option = '<option value="' 
					+ tasks[i].id + '">' 
					+ tasks[i].title 
					+ '</option>';
					$('#task option:last-child').after(
						option
						);
				}

				$('#task').trigger('chosen:updated');
				
			}
		});
	}

	function updateItemList(){
		var projectId 	= $('#project-id').val();
		var taskId 		= $('#task').val();	
		var type		= $('#type').val();

		if(taskId != 0 && type == 'los') {

			$('#item-list option').not(':first').remove();

			$.ajax({ 
				type: 'GET', 
				url: link+'incident-report-headers/get-items/?project_id='+projectId+'&task_id='+taskId, 
				data: { get_param: 'value' }, 
				success: function (data) { 
					var items = data;

					for(var i=0; i < items.length; i++) {
						var option = '<option value="'
						+ items[i] + '"'
						+'>' 
						+ items[i]
						+ '</option>';
						$('#item-list option:last-child').after(
							option	            	
							);
					}

					$('#item-list').trigger('chosen:updated');
					
				}
			});
		}
	}

	function updatePersonList(){

		var projectId 	= $('#project-id').val();
		var taskId 		= $('#task').val();	

		$('#person-list option').not(':first').remove();

		$('#person-list').trigger('chosen:updated');

		$.ajax({ 
			type: 'GET', 
			url: link+'incident-report-headers/get-persons/?project_id='+projectId+'&task_id='+taskId, 
			data: { get_param: 'value' }, 
			success: function (data) { 
				var persons = data;

				for(var i=0; i < persons.length; i++) {
					var value 	= persons[i].occupation + '-' + persons[i].id;
					var option = '<option value="'
					+ value + '"'
					+ ' data-address="'
					+ persons[i].address + '"'
					+ ' data-age="'
					+ persons[i].age + '"'
					+ ' data-contact="'
					+ persons[i].contact + '"'
					+ ' data-occupation="'
					+ persons[i].occupation + '"'
					+'>' 
					+ persons[i].name 
					+ '</option>';
					$('#person-list option:last-child').after(
						option	            	
						);
				}

				$('#person-list').trigger('chosen:updated');
				
			}
		});

	}

	function resetPersonsInvolved() {
		$('#persons-involved').empty();

		$('#persons-involved').html('None.');
	}

	function resetItemsLost() {
		$('#items-lost').empty();

		$('#items-lost').html('None.');
	}

	function resetInjuredInput() {        
		$('#injured-name').val('');
		$('#injured-address').val('');
		$('#injured-age').val('');
		$('#injured-contact').val('');
		$('#injured-occupation').val('');
		$('#injured-summary').val('');
	}

	function resetItemsInput() {        
		$('#item-quantity').val('');
	}

	function appendInvolved(personId, personName, personSummary, type){
			var index       = $('#persons-involved li:last').index() + 1;

			var involved    = '<li'
			+ ' data-id="'
			+ personId + '"'
			+ ' data-name="'
			+ personName + '"'
			+ '>'
			+ personName
			+ '<input type="hidden" name="involved-id[' + index + ']" value="' + personId + '">';

			switch(type) {
				case 'acc':
				case 'doc':
				case 'inj':

				involved     = involved + '<input type="hidden" name="injured-summary[' + index + ']" value="'+personSummary+'">'

				resetInjuredInput();         
				break;
			}

			involved = involved 
			+ '<button class="remove-involved ml btn btn-default" type="button">Remove</button>'
			+ '</li>';

			if(index == 0) {
				$('#persons-involved').empty();
			}

			$('#person-list option[value="' + personId + '"]').prop('disabled', true);

			$('#person-list').trigger('chosen:updated');

			$('#persons-involved').append(
				involved                  
				);
	}

	function appendItem(itemId, itemName, itemQuantity){
		var index       = $('#items-lost li:last').index() + 1;

		var item    = '<li'
		+ ' data-id="'
		+ itemId + '"'
		+ ' data-name="'
		+ itemName + '"'
		+ '>'
		+ itemName
		+ '<input type="hidden" name="item-id[' + index + ']" value="' + itemId + '">'
		+ '<input type="hidden" name="item-quantity[' + index + ']" value="' + itemQuantity + '">'
		+ '<button class="remove-item ml btn btn-default" type="button">Remove</button>'
		+ '</li>';

		resetItemsInput();

		if(index == 0) {
			$('#items-lost').empty();
		}
		$('#item-list option[value="' + itemId + '"]').prop('disabled', true);

		$('#item-list').trigger('chosen:updated');

		$('#items-lost').append(
			item                  
			);
	}

	function populateEditData() {
		setTimeout(function() { 
			var incidentReportData = jQuery.parseJSON($('#incident-report-data').text());

			if(Object.keys(incidentReportData).length){
				$('#task option[value="' + incidentReportData.task + '"]').prop('selected', true);
				$('#task').trigger('chosen:updated');

				updatePersonList();

				if(incidentReportData.type == 'los') {
					updateItemList();
				}
				setTimeout(function() { 

					for (var i = 0; i < incidentReportData.persons_involved.length; i++) {
						var person 				= incidentReportData.persons_involved[i];
						var personId 			= person.occupation + '-' + person.id;
						var personSummary 		= person.injured_summary;
						
						$('#person-list option[value="' + personId + '"]').prop('disabled', true);

						appendInvolved(personId, person.name, personSummary, incidentReportData.type);
					}
					$('#person-list').trigger('chosen:updated');

				}, 1000);

				setTimeout(function() { 

					for (var i = 0; i < incidentReportData.items_lost.length; i++) {
						var item = incidentReportData.items_lost[i];
						var itemId = item.name;
						$('#item-list option[value="' + itemId + '"]').prop('disabled', true);


						appendItem(itemId, itemId, item.quantity);
					}
					$('#item-list').trigger('chosen:updated');

				}, 1000);
			}
		}, 1000);
	}


});