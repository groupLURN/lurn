 $(function(){

 	$("#project-id").chosen().change(function() {
 		projectId =  $(this).val();
 		 $.ajax({ 
	        type: "GET", 
	        url: "http://localhost/projects/lurn/purchase-order-headers/get-milestones?project_id="+projectId, 
	        data: { get_param: 'value' }, 
	        success: function (data) { 
	            var milestones = data;

              	$("#milestone-id option").not(":first").remove();
	            
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




  });