toastr.options = {"preventDuplicates": true, closeButton: true}
if($(".flash-message").length) {
	let flash = ($(".flash-message"));
	let type = (flash.data('type') === 'danger') ? 'error' : flash.data('type');
	let dismiss = flash.data('dismiss');
	let position = flash.data('position');
	let closebutton = (flash.data('closebutton')) ? flash.data('closebutton') : true;
	let message = flash.html();
	let auto_dismiss = (dismiss === 1) ? 5000 : 0;
	toastr[type](message, null, {
		timeOut: auto_dismiss, 
		positionClass: "toast-"+position,
		closeButton: closebutton
	});
}

/**
 * Submit the signnup form with ajax
 */
$('#SignupForm').on('submit', function(e){
	e.preventDefault();

	$.ajax({
		url : baseUrl + "/signup",
		type: "POST",
		data: $(this).serialize(),
		beforeSend: function() {
			$("button.spin").attr("data-send", "true");
			$('button.spin span').hide();
		},
		complete: function() {
			$("button.spin").attr("data-send", "false");
			$('button.spin span').show();
		},
		error: function(response) {
			// Display error messages if authentication fails
			var errors = response.responseJSON.errors;
			var errorMsg = '';
			$.each(errors, function(key, value){
				errorMsg += value[0] + "<br>";
			});
			toastr['error'](errorMsg, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
		},
		success: function(response) {
			toastr[response.type](response.message, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
			if(response.type === 'success')
				window.location.href = response.redirect;
		}
	});
});

/**
 * Submit the login form with ajax
 */
$('#LoginForm').on('submit', function(e){
	e.preventDefault();

	$.ajax({
		url : baseUrl + "/login",
		type: "POST",
		data: $(this).serialize(),
		beforeSend: function() {
			$("button.spin").attr("data-send", "true");
			$('button.spin span').hide();
		},
		complete: function() {
			$("button.spin").attr("data-send", "false");
			$('button.spin span').show();
		},
		error: function(response) {
			// Display error messages if authentication fails
			var errors = response.responseJSON.errors;
			var errorMsg = '';
			$.each(errors, function(key, value){
				errorMsg += value[0] + "<br>";
			});
			toastr['error'](errorMsg, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
		},
		success: function(response) {
			toastr[response.type](response.message, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
			// On successful login, redirect to dashboard
			if(response.type === 'success')
				window.location.href = response.redirect;
		}
	});
});

/**
 * Add task
 */
$("#CreateTask").on("submit", function(e){
	e.preventDefault();

	$.ajax({
		type: "POST",
		dataType: "json",
		url: baseUrl + "/admincp/task/create",
		data: $(this).serialize(),
		beforeSend: function() {
			$("button.spin").attr("data-send", "true");
			$("button.spin span").hide();
		},
		complete: function() {
			$("button.spin").attr("data-send", "false");
			$("button.spin span").show();
		},
		error: function(response) {
			// Display error messages if authentication fails
			var errors = response.responseJSON.errors;
			var errorMsg = '';
			$.each(errors, function(key, value){
				errorMsg += value[0] + "<br>";
			});
			toastr['error'](errorMsg, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
		},
		success: function(response) {
			toastr[response.type](response.message, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
			if(response.type === 'success')
				window.location.href = response.redirect;
		}
	});
});
  
/**
 * Edit task
 * @var id Task id
 */
$("#EditTask").on("submit", function(e){
	e.preventDefault();
	let id = $(this).data('id');
  
	$.ajax({
	  type: "POST",
	  dataType: "json",
	  url: baseUrl + "/admincp/task/update/" + id,
	  data: $(this).serialize(),
	  beforeSend: function() {
		$("button.spin").attr("data-send", "true");
		$("button.spin span").hide();
	  },
	  complete: function() {
		$("button.spin").attr("data-send", "false");
		$("button.spin span").show();
	  },
	  error: function(response) {
		// Display error messages if authentication fails
		var errors = response.responseJSON.errors;
		var errorMsg = '';
		$.each(errors, function(key, value){
			errorMsg += value[0] + "<br>";
		});
		toastr['error'](errorMsg, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
		},
		success: function(response) {
			toastr[response.type](response.message, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
			if(response.type === 'success')
				window.location.href = response.redirect;
		}
	});
});

/**
 * Delete task
 * @param id Task id
 */
function delete_task(id) {
    if (confirm('Are you sure you want to delete this task?')) {
        $.ajax({
            url: baseUrl + '/admincp/task/delete/' + id,
            type: 'DELETE',
            // dataType: 'json',
            data: { _token: csrf_token },  // Send the CSRF token
            success: function (response) {
                // Remove the deleted task
                $("table tr#item-" + id).remove();
                // Show success notification
                toastr[response.type](response.message, null, { positionClass: "toast-bottom-right", closeButton: true, timeOut: 3000 });
            }
        });
    }
    return false;
}

/**
 * Create task category
 */
$("#CreateTaskCategory").on("submit", function(e){
	e.preventDefault();
  
	$.ajax({
		type: "POST",
		dataType: "json",
		url: baseUrl + "/admincp/task/category/create",
		data: $(this).serialize(),
		beforeSend: function() {
			$("button.spin").attr("data-send", "true");
			$("button.spin span").hide();
		},
		complete: function() {
			$("button.spin").attr("data-send", "false");
			$("button.spin span").show();
		},
		error: function(response) {
			// Display error messages if authentication fails
			var errors = response.responseJSON.errors;
			var errorMsg = '';
			$.each(errors, function(key, value){
				errorMsg += value[0] + "<br>";
			});
			toastr['error'](errorMsg, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
		},
		success: function(response) {
			toastr[response.type](response.message, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
			if(response.type === 'success')
				window.location.href = response.redirect;
		}
	});
});

/**
 * Edit task category
 * @var id Category id
 */
$("#EditTaskCategory").on("submit", function(e){
	e.preventDefault();
	let id = $(this).data('id');
  
	$.ajax({
		type: "POST",
		dataType: "json",
		url: baseUrl + "/admincp/task/category/update/" + id,
		data: $(this).serialize(),
		beforeSend: function() {
			$("button.spin").attr("data-send", "true");
			$("button.spin span").hide();
		},
		complete: function() {
			$("button.spin").attr("data-send", "false");
			$("button.spin span").show();
		},
		error: function(response) {
			// Display error messages if authentication fails
			var errors = response.responseJSON.errors;
			var errorMsg = '';
			$.each(errors, function(key, value){
				errorMsg += value[0] + "<br>";
			});
			toastr['error'](errorMsg, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
		},
		success: function(response) {
			toastr[response.type](response.message, null, {positionClass: "toast-bottom-right", closeButton: true, timeOut: 0});
			if(response.type === 'success')
				window.location.href = response.redirect;
		}
	});
});

/**
 * Delete task category
 * @param id The category id 
 */
function delete_task_category(id) {
	alert(baseUrl)
    if (confirm('Are you sure you want to delete this category?')) {
        $.ajax({
            url: baseUrl + '/admincp/task/category/delete/' + id,
            type: 'DELETE',
            // dataType: 'json',
            data: { _token: csrf_token },  // Send the CSRF token
            success: function (response) {
                // Remove the deleted task
                $("table tr#item-" + id).remove();
                // Show success notification
                toastr[response.type](response.message, null, { positionClass: "toast-bottom-right", closeButton: true, timeOut: 3000 });
            }
        });
    }
    return false;
}

/**
 * Search and filter functionality to find tasks easily
 */
function filterTask() {
    var input, filter, table, tr, td1, td2, i, txtValue1, txtValue2;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("tasktable");
    tr = table.getElementsByTagName("tr");
    
    for (i = 1; i < tr.length; i++) { // Skip header row
        td1 = tr[i].getElementsByTagName("td")[1]; // First column (Name)
        td2 = tr[i].getElementsByTagName("td")[2]; // Second column (Category)
        
        if (td1 && td2) {
            txtValue1 = td1.textContent || td1.innerText;
            txtValue2 = td2.textContent || td2.innerText;
            
            // Check if the filter text matches either column
            if (txtValue1.toLowerCase().indexOf(filter) > -1 || txtValue2.toLowerCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}

/**
 * Show/Hide password input
 */
$(document).ready(function() {
    $('.password-visibility').click(function() {
        var icon = $(this).find('i'); 
        var password = icon.parent().prev(); 
        if (password.attr('type') === 'password') {
            password.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            password.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});


$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
