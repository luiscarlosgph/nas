function csrfSafeMethod(method) {
	// these HTTP methods do not require CSRF protection
	return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}

function sameOrigin(url) {
	// test that a given url is a same-origin URL
	// url could be relative or scheme relative or absolute
	var host = document.location.host; // host + port
	var protocol = document.location.protocol;
	var sr_origin = '//' + host;
	var origin = protocol + sr_origin;
	// Allow absolute or scheme relative URLs to same origin
	return (url == origin || url.slice(0, origin.length + 1) == origin + '/') ||
		(url == sr_origin || url.slice(0, sr_origin.length + 1) == sr_origin + '/') ||
		// or any other URL that isn't scheme relative or absolute i.e relative.
		!(/^(\/\/|http:|https:).*/.test(url));
}

function getCookie(name) {
   var cookieValue = null;
   if (document.cookie && document.cookie != '') {
       var cookies = document.cookie.split(';');
       for (var i = 0; i < cookies.length; i++) {
           var cookie = jQuery.trim(cookies[i]);
           // Does this cookie string begin with the name we want?
           if (cookie.substring(0, name.length + 1) == (name + '=')) {
               cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
               break;
           }
       }
   }
   return cookieValue;
}

// Authenticate user through AJAX
function logIn() {
	var csrftoken = getCookie('csrftoken');

	$.ajaxSetup({
		beforeSend: function(xhr, settings) {
			if (!csrfSafeMethod(settings.type) && sameOrigin(settings.url)) {
				xhr.setRequestHeader("X-CSRFToken", csrftoken);
			}
		}
	});

	$.ajax({
		type: 'POST',
		url: '/authentication/login/',
		data: {
			'user': $('#user-input').val(), // from form
			'pass': $('#pass-input').val() // from form
		},
		success: function(response){
			if (response == 'OK') { // Successfully logged in
				$("#submit-login-form").html("<i class=\"glyphicon glyphicon-ok-sign\"></i> Log in");
				window.location.replace('/');
			}
			else {
				$("#login-error-area").empty();
				$("#login-error-area").fadeIn(250);
				var alertBox = '<div data-alert class="alert-box info radius"> Invalid username or password.</div>';
				$("#login-error-area").append(alertBox).foundation();
				// $("#login-columns-div").html = '<div data-alert class="alert-box info radius">Incorrect username or password. <a href="#" class="close">&times;</a></div>' + $("#login-columns-div").html();
				// $(alertBox).foundation('open'); // Fades in success alert
				// $(alertBox).fadeIn(500); // Fades in success alert
				$("#submit-login-form").html("<i class=\"glyphicon glyphicon-log-in\"></i> Log in");
				$('#pass-input').val('');
				$('#pass-input').focus();
			}	
		}
	});
}

// Running foundation
$(document).foundation();

// Footer always in place
$(window).bind("load", function () {
	var footer = $("#footer");
	var pos = footer.position();
	var height = $(window).height();
	height = height - pos.top;
	height = height - footer.height();
	if (height > 0) {
		footer.css({ 'margin-top': height + 'px' });
	}
});

// Modal window focus on first input field
$(document).on('opened.fndtn.reveal', '[data-reveal]', function () {
	$('#user-input').focus();
	$('#old-pass-input').focus();
});

// Empty input fields and errors when closing login modal dialog
$('#close-login-modal').mousedown(function(event) {
	$("#login-error-area").empty();
	$('#user-input').val('');
	$('#pass-input').val('');
});

// Submit post on submit
$('#login-form').on('submit', function(event){
	event.preventDefault();
	logIn();
});

// Handler for enter key in login form
$("#pass-input").keypress(function(event) {
	if (event.which == 13) {
		event.preventDefault();
		$("#submit-login-form").html("<i class=\"glyphicon glyphicon-refresh icon-refresh-animate\"></i> Log in");
		$('#login-form').submit();
	}
});

// Handler for right click on the 'Log in' button in the login form
$('#submit-login-form').mousedown(function(event) {
	event.preventDefault();
	$("#submit-login-form").html("<i class=\"glyphicon glyphicon-refresh icon-refresh-animate\"></i> Log in");
	$('#login-form').submit();
});

// Handler for <a> tag to close the erroneous login message
// FIXME: not working!
/*
$("#close-erroneous-login-msg").mousedown(function(event) {
	window.alert("hello");
	$("erroneous-login-alert").hide();
});
*/

// Creating handlers for focus events of the user and pass input boxes
/*
var userInput = document.getElementById('username-input');
userInput.addEventListener("focus", userFocus);
var passInput = document.getElementById('password-input');
passInput.addEventListener("focus", passFocus);

// Creating handlers for unfocus events of the icons
$('#username-input').blur(function() {
	var icon = document.getElementById("username-icon-i");
	icon.style.border = "1px solid #cccccc";
	icon.style.borderRight = "none";
	icon.style.boxShadow = "none";
});

$('#password-input').blur(function() {
	var icon = document.getElementById("password-icon-i");
	icon.style.border = "1px solid #cccccc";
	icon.style.borderRight = "none";
	icon.style.boxShadow = "none";
});
*/

