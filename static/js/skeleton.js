/*
function userFocus() {
	var icon = document.getElementById("username-icon-i");
	icon.style.transition = "box-shadow 0.45s, border-color 0.45s ease-in-out";
	icon.style.boxShadow = "1px 1px 1px #999999, -1px 0px 1px #999999, 1px -1px 1px #999999";
	icon.style.borderTop = "1px solid #999999";
	icon.style.borderLeft = "1px solid #999999";
	icon.style.borderBottom = "1px solid #999999";
}

function passFocus() {
	var icon = document.getElementById("password-icon-i");
	icon.style.transition = "box-shadow 0.45s, border-color 0.45s ease-in-out";
	icon.style.boxShadow = "1px 1px 1px #999999, -1px 0px 1px #999999, 1px -1px 1px #999999";
	icon.style.borderTop = "1px solid #999999";
	icon.style.borderLeft = "1px solid #999999";
	icon.style.borderBottom = "1px solid #999999";
}
*/

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

// Modal window for login
$(document).on('opened.fndtn.reveal', '[data-reveal]', function () {
	$('#user-input').focus();
});
function submitForm() {
	document.getElementById('login-form').submit();
}
document.getElementById('submit-login-form').addEventListener('click', submitForm);

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

