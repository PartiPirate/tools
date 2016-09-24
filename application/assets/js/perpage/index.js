function updateSkills() {
	$.get("index.php", {}, function(data) {
		var children = $(data).filter("#skills").find("#panel-skills .panel-body").children();
		$("#panel-skills .panel-body").children().remove();
		$("#panel-skills .panel-body").append(children);
	}, "html");
}

function updateEndorsments() {
	$.get("index.php", {}, function(data) {
		var children = $(data).filter("#endorsments").find("#panel-endorsments .panel-body").children();
		$("#panel-endorsments .panel-body").children().remove();
		$("#panel-endorsments .panel-body").append(children);
	}, "html");
}

function endorseSkillHandler() {
	var dialog = $("#dialog-endorse-skill");
	var form = dialog.find("form");
	
	dialog.find(".btn-ok").addClass("disabled").prop("disabled", true);
	
	$.post("skill_api.php?method=do_endorseUserSkill", form.serialize(), function(data) {
		updateEndorsments();
		dialog.find(".btn-ok").removeClass("disabled").prop("disabled", false);
		dialog.modal("hide");
	}, "json");
}

function addSkillHandler() {
	var dialog = $("#dialog-add-skill");
	var form = dialog.find("form");
	
	dialog.find(".btn-ok").addClass("disabled").prop("disabled", true);
	
	$.post("skill_api.php?method=do_addUserSkill", form.serialize(), function(data) {
		updateSkills();
		dialog.find(".btn-ok").removeClass("disabled").prop("disabled", false);
		dialog.modal("hide");
	}, "json");
}

function modifySkillHandler() {
	var dialog = $("#dialog-mod-skill");
	var form = dialog.find("form");
	
	dialog.find(".btn-ok").addClass("disabled").prop("disabled", true);
	
	$.post("skill_api.php?method=do_modifyUserSkill", form.serialize(), function(data) {
		updateSkills();
		dialog.find(".btn-ok").removeClass("disabled").prop("disabled", false);
		dialog.modal("hide");
	}, "json");
}

function deleteSkillHandler() {
	var dialog = $("#dialog-delete-skill");
	var form = dialog.find("form");
	
	dialog.find(".btn-ok").addClass("disabled").prop("disabled", true);
	
	$.post("skill_api.php?method=do_deleteUserSkill", form.serialize(), function(data) {
		updateSkills();
		dialog.find(".btn-ok").removeClass("disabled").prop("disabled", false);
		dialog.modal("hide");
	}, "json");
}

function showEndorseSkillModalHandler() {
	var dialog = $("#dialog-endorse-skill");

	dialog.find(".skill-label").text($(this).parents(".panel").find(".data").data("skill-label"));
	dialog.find(".skill-user-identity").text($(this).parents(".panel").find(".data").data("identity"));
	dialog.find("input[name=sus_id]").val($(this).parents(".panel").find(".data").data("id"));
	
	dialog.modal("show");
}

function showAddSkillModalHandler() {
	var dialog = $("#dialog-add-skill");

	dialog.modal("show");
}

function showModifySkillModalHandler() {
	var dialog = $("#dialog-mod-skill");

	dialog.find(".skill-label").text($(this).data("skill-label"));
	dialog.find("select[name=sus_skill_id]").val($(this).data("skill-id"));
	dialog.find("select[name=sus_skill_id]").change();
	dialog.find("select[name=sus_level]").val($(this).data("skill-level"));
	dialog.find("input[name=sus_id]").val($(this).data("id"));
	
	dialog.modal("show");
}

function showDeleteSkillModalHandler() {
	var dialog = $("#dialog-delete-skill");

	dialog.find(".skill-label").text($(this).data("skill-label"));
	dialog.find("input[name=sus_id]").val($(this).data("id"));
	
	dialog.modal("show");
}

function changeSkillHandler() {
	if ($(this).val() == 0) {
		$(this).parents("form").find(".new-skill").show();
	}
	else {
		$(this).parents("form").find(".new-skill").hide();
	}
}

$(function() {
	
	$("#panel-skills").on("click", ".btn-modify-skill", showModifySkillModalHandler);
	$("#panel-skills").on("click", ".btn-add-skill", showAddSkillModalHandler);
	$("#panel-skills").on("click", ".btn-delete-skill", showDeleteSkillModalHandler);
	
	$("#panel-endorsments").on("click", ".btn-endorse-skill", showEndorseSkillModalHandler);
	$("#panel-endorsments").on("click", ".btn-refresh-skill", updateEndorsments);

	$("#add_sus_skill_id, #mod_sus_skill_id").change(changeSkillHandler);

	$("#dialog-add-skill").on("click", ".btn-ok", addSkillHandler);
	$("#dialog-mod-skill").on("click", ".btn-ok", modifySkillHandler);
	$("#dialog-delete-skill").on("click", ".btn-ok", deleteSkillHandler);
	$("#dialog-endorse-skill").on("click", ".btn-ok", endorseSkillHandler);

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
	
//	$(".panel").resizable({
//		grid: [20, 20],
//		animate: true
//	});
	
	$(".panel").draggable({
		handle: ".panel-heading",
		grid: [20, 20]
	});
	$(".panel, #applications").draggable({
		cancel: "a",
		grid: [20, 20]
	});
});