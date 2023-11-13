const flashdata = $(".flash-data").data("flashdata");

if (flashdata) {
	Swal.fire({
		title: "Success!! ",
		text: flashdata,
		type: "success",
		icon: "success",
	});
}

const flashdata_error = $(
	'<?= $this->session->flashdata("message_error") ?>'
).data("flashdata");
if (flashdata_error) {
	Swal.fire({
		title: "Error!! ",
		text: flashdata_error,
		type: "error",
		icon: "error",
	});
}

// jquery tolong carikan btn-delete yang ketika diklik jalankan fungsi berikut ini
$(document).ready(function () {
	$(".btn-delete").on("click", function (e) {
		e.preventDefault();
		const href = $(this).attr("href");

		console.log(href);
		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, delete it!",
		}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = href;
			}
		});
	});

	// jquery tolong carikan btn-process yang ketika diklik jalankan fungsi berikut ini
	$(".btn-process").on("click", function (e) {
		e.preventDefault();
		const href = $(this).attr("href");

		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, process it!",
		}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = href;
			}
		});
	});

	// sweetalert logout
	$(".btn-logout").on("click", function (e) {
		e.preventDefault();
		const href = $(this).attr("href");

		Swal.fire({
			title: "Are you sure?",
			// text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, sign me out!",
		}).then((result) => {
			if (result.isConfirmed) {
				document.location.href = href;
			}
		});
	});
	$(".btn-confirm").on("click", function (e) {
		e.preventDefault();
		const form = $(this).parents("form");

		Swal.fire({
			title: "Are you sure?",
			text: "You won't be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, confirm!",
		}).then((result) => {
			if (result.isConfirmed) form.submit();
		});
	});
});

function reloadTable() {
	$(tableUser).DataTable().ajax.reload();
}

function swal_success(message) {
	Swal.fire({
		title: "Success!! ",
		text: message,
		icon: "success",
	});
}

function swal_error(message) {
	Swal.fire({
		title: "Failed ",
		text: message,
		icon: "error",
	});
}
