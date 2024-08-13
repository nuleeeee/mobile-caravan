<div class="pt-3"></div>

<div class="container-fluid pt-5 mt-5">
	<div class="row">
		<div class="mb-3">
			<div class="p-3">
				<div class="card text-center">
					<div class="card-header fw-bold ">
						<input type="text" id="txt_prid" class="form-control text-center" placeholder="PR ID">
						<button onclick="fetchDate()" class="btn green-btn w-100 text-center fw-bold mt-1">FETCH</button>
					</div>
					<div class="card-body">
						<div id="grd_sync" style="overflow: auto; max-height: 400px;">
							<img src="assets/icons/sync.png" height="200" alt="">
						</div>
					</div>
					<div class="card-footer text-body-secondary">
						<button id="btn_sync" class="btn green-btn w-100 text-center fw-bold">SYNC</button>
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

	// init();
	function init() {
		$.post("importprovi/php/createtbl.php", {}, function(e) {});
	}

	function fetchDate() {
		txt_prid = $("#txt_prid").val();
		if (txt_prid == "") {
			$("#txt_prid").focus();
			return;
		}
		$("#grd_sync").html(loadGif);
		$.post("importprovi/php/fetchdata.php", {
			txt_prid: txt_prid,
			branch: branchidxx
		}, function(result) {
			$("#grd_sync").html(result);
		});
	}

	$("#btn_sync").on("click", function(e) {
		txt_prid = $("#txt_prid").val();
		if (txt_prid == "") {
			$("#txt_prid").focus();
			return;
		}
		$("#modal_loading_animation").modal("show");
		$.post("importprovi/php/syncing.php", {
			txt_prid: txt_prid,
			branch: branchidxx
		}, function(result) {
			if (result.trim() == "") {
				setTimeout(function() {
					$("#modal_loading_animation").modal("hide");
					shownotif("Data synced!", 1);
					$("#txt_prid").val("");
				}, 1000);
			} else {
				setTimeout(function() {
					$("#modal_loading_animation").modal("hide");
					shownotif(result, 3);
				}, 1000);
			}
		});
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