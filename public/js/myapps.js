const flashData = $(".flash-data").data("flashdata");
//console.log(flashData);

if (flashData) {
	Swal.fire("Success", flashData, "success");
}

//tombol hapus
$(".hapus-link").on("click", function (e) {
	e.preventDefault();
	const href = $(this).attr("href");
	Swal.fire({
		title: "Konfirmasi",
		text: "Are you sure?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonColor: "#3085d6",
		cancelButtonColor: "#d33",
		confirmButtonText: "Yes, deleted",
		cancelButtonText: "cancel",
	}).then((result) => {
		if (result.value) {
			document.location.href = href;
		}
	});
});