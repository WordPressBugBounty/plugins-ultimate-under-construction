checkPage()
checkEm()

function checkPage() {
	if (document.getElementById("custom").checked) {
		document.getElementById("custombg").style.visibility = "visible";
		document.getElementById("custombg").style.display = "block";
		document.getElementById("htmlblockbg").style.visibility = "hidden";
		document.getElementById("htmlblockbg").style.display = "none";
	}
	;

	if (document.getElementById("htmlblock").checked) {
		document.getElementById("htmlblockbg").style.visibility = "visible";
		document.getElementById("htmlblockbg").style.display = "block";
		document.getElementById("custombg").style.visibility = "hidden";
		document.getElementById("custombg").style.display = "none";
	}

};

function checkEm() {
	if (document.getElementById("solidcolor").checked) {
		document.getElementById("solidcolorbg").style.visibility = "visible";
		document.getElementById("solidcolorbg").style.display = "block";
		document.getElementById("patternedbg").style.visibility = "hidden";
		document.getElementById("patternedbg").style.display = "none";
	}
	;

	if (document.getElementById("patterned").checked) {
		document.getElementById("patternedbg").style.visibility = "visible";
		document.getElementById("patternedbg").style.display = "block";
		document.getElementById("solidcolorbg").style.visibility = "hidden";
		document.getElementById("solidcolorbg").style.display = "none";
	}
	;
};