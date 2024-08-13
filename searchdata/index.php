<div class="pt-3"></div>

<div class="container-fluid pt-5 mt-5">
	<div class="row">
		<div class="mb-3">
			<div class="p-3">
				<div class="card text-center">
					<div class="card-header">
						<input type="text" class="form-control text-center" id="getpr" placeholder="PR ID" onchange="getprovidet()">
						<button onclick="getprovidet()" class="btn green-btn w-100 text-center fw-bold mt-1">REFRESH</button>
					</div>
					<div class="card-body">
						<div class="col-lg-12" id="grd_providet" style="overflow-x: scroll; margin-top: 10px">
						</div>
					</div>
					<div class="card-footer text-body-secondary">
						<button class="btn green-btn w-100 text-center fw-bold mt-2" onclick="print_receipt()">PRINT</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include "modal.php"; ?>

<script>
	var loadGif = "<p align='center'><img src=\"assets/loading.gif\" width=\"30%\"></p>";
	var branchidxx = localStorage.getItem("branch");
	var prid = 0;

	getprovidet();

	function getprovidet()
	{
		$("#grd_providet").html(loadGif);
		prid = $("#getpr").val();
		$.post("searchdata/php/getprovidet.php", {
			prid: prid,
			branch: branchidxx
		}, function(result) {
			data = JSON.parse(result);
			$("#grd_providet").html(data.tbl);
			$("#printview").html(data.print);
		});
	}

	// Removed export to excel; this is changed with print to pdf
	/*$("#btn_export").on("click", function()
	{
		var table = document.getElementById("tbl_providet");
		var originalPageLength = $('#tbl_providet').DataTable().page.len();
		$('#tbl_providet').DataTable().page.len(-1).draw();

		var wb = XLSX.utils.book_new();
		var ws = XLSX.utils.table_to_sheet(table);
		XLSX.utils.book_append_sheet(wb, ws, "test");

		XLSX.writeFile(wb, "PR Data.xlsx");

		$('#tbl_providet').DataTable().page.len(originalPageLength).draw();
	});*/

	function print_receipt() {
		$("#modal_print").modal("show");
	}

	$("#btn_print_push").off("click").on("click", function() {
		var divToPrint = document.getElementById('printviewouter').innerHTML;
		var newWin = window.open('', 'Print-Window');
		newWin.document.open();
		newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="stylesheets/printform.css"></head><body onload="window.print()">' + divToPrint + '</body></html>');
		newWin.document.close();
		setTimeout(function() {
			newWin.close();
			$("#modal_print").modal("hide");
		}, 100);
	});
	
	function shownotif(msg,type)
	{
		$('#modal_notification').modal('show');
		$("#notif_1").hide();
		$("#notif_2").hide();
		$("#notif_3").hide();
		$("#notif_4").hide();
		var_forshow = "#notif_" + type;

		$("#notif_txt").html(msg);
		$(var_forshow).show();
	}

</script>