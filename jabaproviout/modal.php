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
					Notification
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid text-break">
					<label id="notif_txt"></label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- DISCOUNT PIN POPUP -->
<div class="modal fade" id="modal_vat"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Vat</h5>
			</div>
				<div class="modal-body">
					<div class="info-box">
						<div class="info-box-content">
							<span class="info-box-text">Non Vat</span>
							<input type="checkbox" class="form-check-input" id="cmb_nonvat">
						</div>
						<div class="info-box-content">
							<span class="info-box-text">Wot 2307</span>
							<input type="checkbox" class="form-check-input" id="cmb_wot2307">
						</div>
						<div class="info-box-content">
							<span class="info-box-text">Wot 2306</span>
							<input type="checkbox" class="form-check-input" id="cmb_wot2306">
						</div>
					</div>
				<div class="info-box-content d-flex justify-content-end">
					<button class="btn btn-success w-100 mt-3" onclick="checkvat()">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- SEARCH BY ITEMCODE -->
<div class="modal fade" id="modal_searchitem"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Search Result</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="col-lg-12" id="grd_result_search" style="overflow: scroll">

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_search_close">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- SEARCH BY ITEM -->
<div class="modal fade" id="modal_searchbyitem"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">ITEM SEARCH</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="col-lg-12">
						<label>Search Item</label>
						<input class="form-control" id="txt_itemsearch" placeholder="Item description then press enter" type="text">
						<button class="btn btn-primary w-100 mt-2" id="btn_search_item">Search</button>
						<hr>
					</div>

					<div class="col-lg-12" style="padding-top: 20px; overflow: scroll;height: 300px" id="grd_itemsearch">

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- ENDTRANS POPUP -->
<div class="modal fade" id="endtrans"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><b>Payment Details</b></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-4">
							<div class="info-box-content">
								<span class="info-box-text">Gross Payable</span>
								<input class="form-control text-end" placeholder="Payable" id="txt_payable" readonly>
							</div>
						</div>
						<div class="col-lg-4">

						</div>
						<div class="col-lg-4">
							<div class="info-box-content">
								<span class="info-box-text">Remaining Payable</span>
								<input class="form-control text-end" placeholder="Remaining" id="txt_rempayable" readonly>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12" id="salespaytgrd" style="height: 250px; margin-top: 10px;margin-bottom: 10px; overflow: scroll">

						</div>
					</div>

					<div class="row">
						<div class="info-box-content">
							<span class="info-box-text">Mode of payment</span>
						</div>
					</div>
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<button class="btn w-100 mt-2" style="background-color: green; border: none; color:white;text-align: center" onclick="focustxt('txt_cash','modal_cashpayt','txt_cash')" id="btn_paycash"><u>C</u>ash</button>
							</div>
							<div class="info-box-content">
								<button class="btn w-100 mt-2" style="background-color: maroon; border: none; color:white;"  onclick="focustxt('txt_creditcodecashier','modal_creditcardpayt','txt_creditcard')" id="btn_paycreditcard">Credi<u>t</u>Card</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- CASH POPUP -->
<div class="modal fade" id="modal_cashpayt"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cash Tendered</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<input class="form-control" type="number" value="0.00" id="txt_cash" style="height: 100px; font-size:50px;">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<span class="info-box-text">Cash Change</span>
								<input class="form-control" value="0.00" id="txt_cashchange" style="height: 100px; font-size:50px;" disabled>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success w-100 mt-2" id="save_cash_tendered">Save</button>
				<button class="btn text-white bg-black w-100 mt-2 d-none" id="print_receipt">Print</button>
			</div>
		</div>
	</div>
</div>

<!-- CREDIT CARD POPUP -->
<div class="modal fade" id="modal_creditcardpayt"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Credit Card</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<button class="btn w-100 mt-2" style="background-color: orange; border: none; color:white;" onclick="setbankname('METROBANK',1)" id="bank_metro"><u>M</u>ETROBANK</button>
							</div>
							<div class="info-box-content">
								<button class="btn w-100 mt-2" style="background-color: orange; border: none; color:white;" onclick="setbankname('BPI',2)" id="bank_bpi"><u>B</u>PI</button>
							</div>
							<div class="info-box-content">
								<button class="btn w-100 mt-2" style="background-color: orange; border: none; color:white;" onclick="setbankname('BDO',3)" id="bank_bdo">BD<u>O</u></button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<span class="info-box-text">Bank</span>
								<input class="form-control" id="txt_bankname" disabled>
							</div>
							<div class="info-box-content">
								<span class="info-box-text">Reference</span>
								<input class="form-control" maxlength="12" id="txt_bankreference">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<input class="form-control mt-2" type="number" value="0.00" id="txt_creditcard" style="height: 80px; font-size:40px;">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">
								<button class="btn w-100 mt-2 btn-success" id="btn_save_bank_payt">Save</button>
								<button class="btn w-100 mt-2 text-white bg-black d-none" id="btn_save_bank_print">Print</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- PRINT --> <!-- added a little backdrop effect --> 
<div class="modal fade" id="modal_print"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
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
							<div style="font-size: 80px; font-family: Impact; letter-spacing: 10px; color: #000000;">JABA</div>
							<div style="font-size: 20px; font-family: Impact; letter-spacing: 10px; margin-top: -18px;">SUPERMARKET</div>
							<div style="text-align: center; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 9pt;">OPERATED BY MAQUILING HARDWARE LUMBER</div>
						</div>
						<div id="lucbr" style="text-align: center; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 9pt; display: none;">
							<div>National Highway, Barangay Isabang, Tayabas, Quezon, Tayabas, Philippines</div>
							<div>Contact No: 0977 709 7440</div>
						</div>
						<div id="psjbr" style="text-align: center; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 9pt; display: none;">
							<div>National Road, Brgy. Sampaloc, Pagsanjan, Philippines</div>
							<div>Contact No: 0927 172 1025</div>
							<div>Email Us: jaba.pagsanjan@gmail.com</div>
						</div>
						<div style="margin-top: 10px; text-align: center; font-size: 20pt; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace;">
							<div>DELIVERY RECEIPT</div>
						</div>
						<div style="width: 100%; margin-top: 20px; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 9pt;" id="printview">

						</div>
						<div style="float: right; font-weight: bold; padding: 20px; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 9pt;">
							<table style="text-align: end;">
								<tr>
									<td>TOTAL:</td>
									<td><span id="total_amt"></span></td>
								</tr>
								<tr>
									<td>CASH:</td>
									<td><span id="total_cash"></span></td>
								</tr>
								<tr>
									<td>CHANGE:</td>
									<td><span id="total_change"></span></td>
								</tr>
							</table>
						</div>
						<br><br><br><br><br><br><br><br><br><br>
						<div style='text-align: center; font-family: Courier New,Courier,Lucida Sans Typewriter,Lucida Typewriter,monospace; font-size: 9pt;'>
							<div>*** <i>THIS IS NOT AN OFFICIAL RECEIPT</i> ***</div>
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

<!-- VAT POPUP -->
<div class="modal fade" id="modal_vat"  tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Vat</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="info-box">
							<div class="info-box-content">						
								<input type="checkbox" id="rd_nonvat" onclick='checknonvat()'>
								<label class='form-check-label' for='radiovatsales'>Non Vat</label>
							</div>
							<div class="info-box-content">
								<input type="checkbox" id="rd_wot2307" onclick='check2307()'>
								<label class='form-check-label' for='radiovatsales'>WOT 2307</label>
							</div>
							<div class="info-box-content">
								<input type="checkbox" id="rd_wot2306" onclick='check2306()'>
								<label class='form-check-label' for='radiovatsales'>WOT 2306</label>
							</div>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="insertpaytwot()">Save</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_search_close">Close</button>
			</div>
		</div>
	</div>
</div>