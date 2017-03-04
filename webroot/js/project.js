$(function(){
	var link = $('#base-link').text();

	$('#add-file').on('click', function() {

		if ($('#files-added div').length == 0) {
			$('#files-added').text('');
		}

		var fileBlock = 
			'<div class="file-block">'
			+'<div class="row">'
			+ '<div class="col-sm-12">'
			+ '<label>File Label</label>'
			+ '<input name="file-label[]" class="form-control" type="text">'
			+ '</div>'
			+ '<br>'
			+ '<div class="col-sm-10">'
			+ '<input name="file[]" type="file">'
			+ '</div>'
			+ '<div class="col-sm-2">'
			+ '<button type="button" class="remove-file btn btn-default pull-right">Remove File</button>'
			+ '</div>'
			+ '</div>'
			+ '</div>';

		$('#files-added').append(fileBlock);
	});

	$('#files-existing').on('click', '.remove-file', function() {
		$(this).closest('.file-block').remove();
		if ($('#files-existing div').length == 0) {
			$('#files-existing').text('None.');
		}
	});

	$('#files-added').on('click', '.remove-file', function() {
		$(this).closest('.file-block').remove();
		if ($('#files-added div').length == 0) {
			$('#files-added').text('None.');
		}
	});

	window.onload = function() {

	}
});