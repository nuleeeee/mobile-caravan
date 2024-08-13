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
			<div class="modal-body">
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
		
<!-- PRINT --> <!-- added a little backdrop effect --> 
<div class="modal fade" id="modal_print"  tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header"> 
				<h5 class="modal-title">Print Preview</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn_close_print">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="col-lg-12" id="printviewouter"  style="height: 300px; overflow-y: scroll; padding-top:5px;">
						<div style="text-align: center;">
							<div style="font-size: 100px; font-family: Impact; letter-spacing: 10px;-webkit-text-stroke: 3px #000000; color: #FFFFFF;">JABA</div>
							<div style="font-size: 20px; font-family: Impact; letter-spacing: 10px; margin-top: -20px;">SUPERMARKET</div>
							<div style="text-align: center; font-family: Courier New; font-size: 12pt;">National Road, Brgy. Sampaloc, Pagsanjan, Philippines</div>
							<div style="text-align: center; font-family: Courier New; font-size: 12pt;">Contact No: 0927 172 1025</div>
							<div style="text-align: center; font-family: Courier New; font-size: 12pt;">Email Us: jaba.pagsanjan@gmail.com</div>
						</div>
						<div style="width: 100%; margin-top: 20px; font-family: Courier New; font-size: 12pt;" id="printview">

						</div>
						<div style="text-align: end; font-weight: bold; padding: 20px;">
							TOTAL: <span id="total_amt" style="font-size: 20px;"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="btn_print_push">Print</button>
			</div>
		</div>
	</div>
</div>