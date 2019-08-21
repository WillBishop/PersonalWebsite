function getAge(dateString) {
	var today = new Date();
	var birthDate = new Date(dateString);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		age--;
	}
	return age;
}
document.addEventListener("DOMContentLoaded", function(event) {
	var inner = document.getElementsByClassName("center")[1];
	inner.innerHTML = inner.innerHTML.replace("17", getAge("2002/03/23"));
});