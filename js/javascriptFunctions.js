// JavaScript Document

function checkForm(form) {
	// Get all inputs within the submitted form
	var inputs = form.getElementsByTagName('input');
	for (var i = 0; i < inputs.length; i++) {
		// Only validate the inputs that have the required attribute
		if (inputs[i].hasAttribute("required")) {
			if (inputs[i].value.trim() == "") {
				alert("Please fill all required fields!");
				return false;
			}
		}
	}
	return true;
}