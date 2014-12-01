function validateCitySearch() {
	var cityLookup = document.forms["citySearch"]["cityName"];
	if(cityLookup == "") {
		alert("A valid City must be entered");
		return false;
	}
