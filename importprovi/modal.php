<!-- NOTIFICATION POPUP -->
<div class="modal fade" id="modal_notification"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<img src="assets/icons/success.png" id="notif_1" style="width:50px"/>
					<img src="assets/icons/warning.png" id="notif_2" style="width:50px"/>
					<img src="assets/icons/error.png" id="notif_3" style="width:50px"/>
					<img src="assets/icons/information.png" id="notif_4" style="width:50px"/>
					Notification</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				<!-- <span>&times;</span> -->
				</button>
			</div>
			<div class="modal-body" style="overflow-y: scroll; max-height: 500px;">
				<div class="container-fluid">
					<label id="notif_txt"></label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!--  data-bs-keyboard="false" data-bs-backdrop="static" -->

<!-- NOTIFICATION POPUP -->
<div class="modal fade" id="modal_loading_animation"  tabindex="-1" role="dialog" data-bs-keyboard="false" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="container-fluid">
					<label class="fw-bold">Syncing...</label>
					<div class="progress" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>