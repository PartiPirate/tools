$(function() {
	$(".btn-upgrade-redmine-password").click(function(event) {
		event.stopPropagation();
		event.preventDefault();

		if ($(this).hasClass("disabled")) return;

		$(this).addClass("disabled");

		var href = $(this).attr("href");
		$.post(href, {}, function(data) {
			$(".div-upgrade-redmine-password").remove();
		}, "json");
	});
});