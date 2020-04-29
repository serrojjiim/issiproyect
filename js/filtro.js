function popup(n) {
	var popup = document.getElementsByClassName("popuptext")[n];
	var popuptext = document.getElementsByClassName("popuptext")[n];
	var th = document.getElementsByTagName("th")[n];
	var offset = $(th).offset();
	event.stopPropagation();
	var topOf = offset.top;
	var leftOf = offset.left;
	$(popup).offset({
		top : topOf - 60,
		left : leftOf
	});
	popuptext.classList.toggle("show");
}