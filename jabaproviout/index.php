<div class="pt-3"></div>

<div class="container-fluid pt-5 mt-4">
	<div class="container mt-3 mb-5">
		<div class="rounded-3 p-3 shadow-sm bg-white">
			<div class="row">
				<div class="form-floating mb-3">
					<input class="form-control text-center" id="txt_invidz" readonly>
					<label for="txt_invidz" class="m-1">Transaction ID</label>
				</div>

				<div class="form-floating mb-3">
					<input class="form-control text-center" id="txt_salesinvoice">
					<label for="txt_salesinvoice" class="m-1">Sales Invoice</label>
				</div>

				<div class="form-floating mb-3">
					<input class="form-control text-center" id="txt_salessoldto" readonly>
					<label for="txt_salessoldto" class="m-1">Customer Name</label>
				</div>

				<div class="form-floating mb-3">
					<button class="btn text-white bg-black w-100" onclick="searchItem()">SEARCH ITEM</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container mt-3">
		<div class="rounded-3 p-3 shadow-sm bg-white">
			<div class="row">
				<div class="col-lg-12" id="grd_salesdet" style="overflow-x: scroll; height: 370px; margin-top: 10px">

				</div>
			</div>
		</div>
	</div>

	<div class="container mt-3 mb-5">
		<div class="rounded-3 p-3 shadow-sm bg-white">
			<div class="form-floating mb-3">
				<input class="form-control text-center" id="txt_barcode" accesskey="1">
				<label for="txt_barcode" class="m-1">Barcode</label>
			</div>

			<div class="form-floating mb-3">
				<input class="form-control text-center" id="txt_desciption" readonly>
				<label for="txt_desciption" class="m-1">Description</label>
			</div>

			<div class="form-floating mb-3">
				<input class="form-control text-center" id="txt_qty" value="1.00" disabled>
				<label for="txt_qty" class="m-1">Quantity</label>
			</div>

			<div class="form-floating mb-3">
				<input class="form-control text-center" id="txt_srp" type="number" value="1.00" disabled>
				<label for="txt_srp" class="m-1">Price</label>
			</div>

			<div class="form-floating mb-3">
				<input class="form-control text-center" id="txt_amt" value="1.00" readonly>
				<label for="txt_amt" class="m-1">Amount</label>
			</div>

			<div class="form-floating mb-3">
				<button class="btn btn-primary w-100" id="btn_add">Add</button>
			</div>

			<div class="form-floating mb-3">
				<button class="btn btn-success w-100" id="btn_end">End</button>
			</div>
		</div>
	</div>
</div>

<div id="receiver" style="display: none"></div>

<?php include "modal.php"; ?>

<script>
	var loadGif = "<p align='center'><img src=\"assets/loading.gif\" width=\"30%\"></p>";
	var loadGifprint = "<p align='center'><img src=\"assets/loading.gif\" width=\"30%\"></p>";
	var cashiername = localStorage.getItem("login_name");
	var branchidxx = localStorage.getItem("branch");
	var datetoday = formatDate(new Date());

	var var_pridz = -1;
	var var_invidz = -1;
	var var_invno = "";
	var var_qty = 0;
	var var_itemcount = 0;
	var var_itemidz = 0;
	var var_prdetidz = 0;
	var var_salesprice = 0;
	var var_srpitem = 0;
	var var_soldtoname = "";
	var var_soldtoidz = 0;
	var var_amount = 0;
	var var_bpitem = 0
	var var_invprice = 0
	var var_nanoidz = 1;
	var var_bxstatus = 0;
	//init();
	var var_payable = 0;
	var var_grosspayable = 0;
	var var_totalmlidisc = 0;
	var var_totalsupdisc = 0;
	var var_totalmlidiscpromo = 0;
	var var_totalsupdiscpromo = 0;
	var var_chkdate = formatDate(new Date());
	var datenow = formatDate(new Date());
	//VAT
	var var_nonvat = 0;
	var var_2307 = 0;
	var var_2306 = 0;
	//COUPON
	var var_couponcode = "";
	var var_couponidxx = 0;
	//VOID
	var var_voidinvidz = 0;
	var var_voidinvdetidz = 0;
	var var_voidrefqty = 0;
	var var_voidnameidz = 0;
	var var_voiditemidz = 0;
	var var_voiditemcode = '';
	var var_soldtodelinfo = "";
	var var_delinfonameidxx = 0;
	//ENABLE
	var var_enablebtn = "";
	var var_randcodeenable = 0;
	//CLEAR
	var var_clearnameidz = 0;
	init();

	function init()
	{
		var_clearnameidz = 0;
		var_pridz = -1;
		$.post("jabaproviout/php/init_proviout.php",{var_clearnameidz:var_clearnameidz,var_pridz:var_pridz,branch: branchidxx},function(result){
			$("#txt_pridz").focus();
			$("#txt_pridz").select();
			getprovidet();
			getsalesdet();
			getnewtransid();
			getnewsino();
			getcustomer();
		});
		$("#txt_barcode").focus().select();
	}

	function searchItem() {
		$("#modal_searchbyitem").modal('show');

		$("#btn_search_item").on("click", function(e) {
			brcode = $("#txt_itemsearch").val();
			$.post("jabaproviout/php/getitemsearch_sales.php", {type:1,brcode: brcode,branch: branchidxx}, function(result){
				$("#grd_itemsearch").html(result);
			});
		});
	}

	function checkvat()
	{
		var_nonvat = 0;
		var_2307 = 0;
		var_2306 = 0;

		if ($('#cmb_nonvat').is(':checked'))
		{
			var_nonvat = 1;
		}
		if ($('#cmb_wot2307').is(':checked'))
		{
			var_2307 = 1;
		}
		if ($('#cmb_wot2306').is(':checked'))
		{
			var_2306 = 1;
		}

		initload();
		getprovidet();
		getsalesdet();
		getcustomer();
		$("#modal_vat").modal("hide");
	}

	function initload()
	{
		$.post("jabaproviout/php/init_proviout.php",{var_clearnameidz:var_clearnameidz,var_pridz:var_pridz,branch: branchidxx},function(result){
			getnewtransid();
			getnewsino();
		});
	}

	function getnewtransid()
	{
		$.post("jabaproviout/php/getnewtransid.php",{branch: branchidxx},function(result){
			var_invidz = result;
			$("#txt_invidz").val(var_invidz);
		});
	}

	function getnewsino()
	{
		$.post("jabaproviout/php/getnewsino.php",{branch: branchidxx},function(result){
			var_invno = result;
			$("#txt_salesinvoice").val(var_invno);
		});
	}

	function getcustomer()
	{
		$.post("jabaproviout/php/getsuppliername.php",{var_pridz:var_pridz,branch: branchidxx},function(result)
		{
			$("#receiver").html(result);
		});
	}

	function getprovidet()
	{
		$("#grd_providet").html(loadGif);
		$.post("jabaproviout/php/getprovidet.php",{var_pridz:var_pridz,branch: branchidxx},function(result)
		{
			$("#grd_providet").html(result);
		});
	}

	function getsalesdet()
	{
		$("#grd_salesdet").html(loadGif);
		$.post("jabaproviout/php/getsalesdet.php",{var_invidz:var_invidz,branch: branchidxx},function(result)
		{
			$("#grd_salesdet").html(result);
			if(var_itemcount >= 1)
			{
				$("#txt_salesinvoice").prop('disabled',true);
				$("#txt_invidz").prop('disabled',true);
			}
			else
			{
				$("#txt_salesinvoice").prop('disabled',false);
				$("#txt_invidz").prop('disabled',false);
			}
		});
	}

	function addqty(pritem,pritemcode,prdetid,pritemid,prprice,prvbprice,prvsprice,rtrnitem,remainingqty)
	{
		var_invno = $("#txt_salesinvoice").val();
		if ($('#rmv_promochk').is(':checked'))
		{
			var_autodisc = 0;
		}
		else
		{
			var_autodisc=1;
		}
		var txtqtyname = "#txt_qty_" + Math.floor(prdetid);
		var_qty = $(txtqtyname).val();
		if(var_qty<=0)
		{
			shownotif("Not allowed",2);
			return;
		} else if(var_qty>remainingqty) {
			shownotif("Not allowed",2);
			return;
		}
		if (rtrnitem == "") {
			shownotif("No actual quantity returned for this item.");
			return;
		}
		$.post("jabaproviout/php/insert_prsalesdet_sales.php",{var_pridz:var_pridz,var_invidz:var_invidz,prdetid:prdetid,pritemid:pritemid,pritem:pritem,pritemcode:pritemcode,var_qty:var_qty,prprice:prprice,var_invno:var_invno,prvbprice:prvbprice,prvsprice:prvsprice,var_soldtoidz:var_soldtoidz,var_autodisc:var_autodisc,branch: branchidxx},function(result){
			$('#btn_add').prop('disabled', false);
			$("#rmv_promochk").prop('disabled',true);
			getsalesdet();
		});
	}

	$("#txt_barcode").on("change", function(e){
		if ($('#modal_print').is(':visible'))
		{
			return;
		}
		
		brcode = $("#txt_barcode").val();
		if(brcode.length<2)
		{
			shownotif("At least 2 letters required",2);
			return;
		}
		else
		{
			var n = brcode.includes("@");
			if(n)
			{
				if($.isNumeric(getCharsBefore(brcode)))
				{
					var_qty = getCharsBefore(brcode);
					brcode = getCharsafter(brcode);
				}
				else
				{
					if(getCharsBefore(brcode) == 'kg')
					{
						brcode = getCharsafter(brcode);
					}
					else
					{
						msg = "Invalid Quantity";
						shownotif(msg,3);
						return;
					}
				}
			}
			else
			{
				var_qty = 1;
			}

			$('#grd_result_search').html(loadGif);
			$.post("jabaproviout/php/getitemsearch_sales.php",{type:0,brcode:brcode,branch: branchidxx},function(result){
				$('#grd_result_search').html(result);
			});
		}
	});

	function setitem(itemdesc,itemcode,sprice,itemidz,cntitem,boxqty,boxdisc,searchtype,qtybaboy,concesstype)
	{
		var_bxdisc = 0;
		if(cntitem<=1)
		{
			$('#modal_searchitem').modal('hide');
		}
		if(var_bxstatus == 0)
		{
			$('#txt_qty').val(var_qty);
		}
		else
		{
			if(var_bxstatus == 0)
			{
				$('#txt_qty').val(1);
			}
			else
			{
				$('#txt_qty').val(qtybaboy);
			}
		}

		var_item = itemdesc;
		var_itemcode = itemcode;
		var_itemidz = itemidz;
		$('#txt_desciption').val(itemdesc);
		$('#txt_punchitem').html(itemdesc);
		$('#txt_srp').val(sprice);
		$('#txt_punchprice').html(sprice);
		var_srpitem = sprice;
		var_amount = sprice * var_qty;
		var_bpitem = sprice;

		$('#txt_amt').val(var_amount);

		if(searchtype == 0)
		{
			$("#txt_qty").prop('disabled',true);
			$("#txt_srp").prop('disabled',true);
			$("#btn_add").click();
		}
		else
		{
			if(concesstype == 2)
			{
				$("#txt_qty").prop('disabled',false);
				$("#txt_srp").prop('disabled',true);
			}
			else
			{
				$("#txt_qty").prop('disabled',false);
				$("#txt_srp").prop('disabled',false);
			}

			$("#txt_qty").focus();
			$("#txt_qty").select();
		}
	}

	$("#txt_qty").on("change", function(e){
		$('#txt_amt').val(var_srpitem * $('#txt_qty').val());
		$("#btn_add").focus().select();
	});

	$("#btn_add").click(function(e){
		$('#btn_add').prop('disabled', true);
		if (isDoubleClicked($(this))) return;
		var_qty = $("#txt_qty").val();

		if($('#txt_srp').val()<var_srpitem)
		{
			msg = "Not allowed less than the SRP";
			shownotif(msg,3);
			$('#txt_srp').val(var_srpitem);
			return;
		}

		if(var_qty<=0)
		{
			msg = "Not allowed quantity";
			shownotif(msg,3);
			$("#txt_qty").val(1);
			$("#txt_qty").focus().select();
			return;
		}
		var_invno = $("#txt_salesinvoice").val();
		if(var_invno == "")
		{
			msg = "No Sales Invoice";
			shownotif(msg,3);
			return;
		}

		if(var_pridz == 0)
		{
			msg = "Wait for transaction ID to load";
			shownotif(msg,3);
			return;
		}

		var_invprice = $("#txt_srp").val();
		if(var_srpitem > var_invprice)
		{
			msg = "Amount lower than Selling Price";
			shownotif(msg,3);
			return;
		}

		if ($('#rmv_promochk').is(':checked'))
		{
			var_autodisc = 0;
		}
		else
		{
			var_autodisc=1;
		}

		$("#rd_nonvat").prop('disabled',false);
		$("#rd_wot2307").prop('disabled',false);
		$("#rd_wot2306").prop('disabled',false);

		$.post("jabaproviout/php/insert_salesdet_sales.php",{var_invidz:var_invidz,var_soldtoidz:var_soldtoidz, var_invno:var_invno,var_itemidz:var_itemidz,var_bpitem:var_bpitem,var_srpitem:var_srpitem,var_invprice:var_invprice,var_qty:var_qty, var_nanoidz:var_nanoidz,var_item:var_item,var_itemcode:var_itemcode,var_bxdisc:var_bxdisc,var_autodisc:var_autodisc,var_pridz:var_pridz,branch: branchidxx},function(result){
			$("#rmv_promochk").prop('disabled',true);
			$('#btn_add').prop('disabled', false);
			$("#txt_qty").prop('disabled',true);
			$("#txt_srp").prop('disabled',true);
			if(result.trim()!="")
			{
				shownotif(result,2);
			}
			else
			{
				var_qty = 1;
				getsalesdet();
				$("#txt_barcode").focus().select();
			}
		});
	});

	//VOID
	function setvoid(invidz,invdetidz,refqty,itemidz,itemcode)
	{
		$("#txt_voidpin").val("");
		var_voidinvidz = invidz;
		var_voidinvdetidz = invdetidz;
		var_voidrefqty = refqty;
		var_voiditemidz = itemidz;
		var_voiditemcode = itemcode;

		insertvoid();
	}

	function insertvoid()
	{
		$.post("jabaproviout/php/insert_salesvoid_proviout.php",{invidz:var_voidinvidz,invdetidz:var_voidinvdetidz,refqty:var_voidrefqty,var_voidnameidz:var_voidnameidz,var_voiditemidz:var_voiditemidz,var_voiditemcode:var_voiditemcode,branch: branchidxx},function(result){
			getsalesdet();
		});
	}

	$("#txt_codeenable").on("change", function(e){
		var var_code  = Number($("#txt_codeenable").val());
		$.post("jabaproviout/php/getnameidenable.php",{var_code:var_code,var_randcode:var_randcodeenable,branch: branchidxx},function(result)
		{
			if(result==-1)
			{
				alert("WRONG CODE!");
			}
			else if(result == -2)
			{
				alert("NOT OFFICER CODE!");
			}
			else
			{
				$('#modal_suppcode').modal('hide');
				enableinputsup(result);
			}
		});
	});

	function enableinputsup(suppamt)
	{
		$("#" + var_enablebtn).val(suppamt);
		//$("#" + var_enablebtn).prop('disabled',false);
	}

	//CHANGE NANO
	function gettypedetails()
	{
		$("#grd_typedetails").html(loadGif);
		$.post("jabaproviout/php/getsalesdetails_proviout_type.php",{var_invidz:var_invidz,branch: branchidxx},function(result){
			$("#grd_typedetails").html(result);
		});
	}

	function setnanodetails(invidz,invdetidz,nanoidz)
	{
		$.post('jabaproviout/php/insert_type_proviout.php',{invidz:invidz,invdetidz:invdetidz,nanoidz:nanoidz,branch: branchidxx},function(result){
			gettypedetails();
			getsalesdet();
		});
	}

	function setallnanodetails(nanoidz)
	{
		$.post('jabaproviout/php/insert_alltype_proviout.php',{var_invidz:var_invidz,nanoidz:nanoidz,branch: branchidxx},function(result){
			gettypedetails();
			getsalesdet();
		});
	}


	//PAYMENT

	$("#btn_end").click(function(e){
		$("#endtrans").modal("show");
		//$('#btn_save_end').prop('disabled', true);
		//$('#btn_add_end').prop('disabled', true);

		//compuid = $('#txt_compuid').val();

		initsalespayment();
	});

	function initsalespayment()
	{
		$("#txt_payable").val(var_grosspayable);
		$.post('jabaproviout/php/init_salespayment_proviout.php',{var_pridz:var_pridz,var_invidz:var_invidz,var_grosspayable:var_grosspayable,var_totalmlidisc:var_totalmlidisc,var_totalsupdisc:var_totalsupdisc,var_invno:var_invno,var_totalmlidiscpromo:var_totalmlidiscpromo,var_totalsupdiscpromo:var_totalsupdiscpromo,var_soldtoidz:var_soldtoidz,var_nonvat:var_nonvat,var_2307:var_2307,var_2306:var_2306,branch: branchidxx},function(result){
			$("#receiver").html(result);
			getsalespayment();
		});
	}

	function getsalespayment()
	{
		$("#salespaytgrd").html(loadGif);
		$.post('jabaproviout/php/getsalespayment_proviout.php',{var_invidz:var_invidz,branch: branchidxx},function(result){
			$("#salespaytgrd").html(result);
		});
	}

	function focustxt(txt_tofocus,frm_modal,txt_init)
	{
		var_status = 0;
		$("#" + txt_tofocus).prop('disabled', false);
		$("#txt_cheque").prop('disabled', false);
		$("#txt_creditcard").prop('disabled', false);
		$("#txt_chqnum").val("");
		$("#txt_cashchange").val(0.00);
		$("#endtrans").modal('hide');
		$("#txt_bankname").val("");
		$("#txt_bankreference").val("");
		//$("#txt_creditcodecashier").val("");
		$("#txt_couponid").val("0.00");
		$("#txt_coupon").val("0.00");

		var_bankid = 0;
		var_creditcardok = 0;

		$('#' + frm_modal).modal('show');

		$('#' + frm_modal).on('shown.bs.modal', function () {
			$("#" + txt_tofocus).focus();
			$("#" + txt_tofocus).select();
		});
	}

	function showmodal()
	{
		$("#endtrans").modal('show');
	}


	// $("#txt_cash").on("change", function(e){
	$("#save_cash_tendered").on("click", function(e) {
		var amt = $("#txt_cash").val();
		if(amt <= 0)
		{
			msg = "Invalid Amount";
			shownotif(msg,3);
			return;
		}

		var_delinfonameidxx = 0;
		var_soldtodelinfo = "";
		var_chkdate = formatDate(new Date());
		$("#txt_cash").prop('disabled', true);
		$("#save_cash_tendered").addClass('d-none');
		$("#print_receipt").removeClass('d-none');

		var dbcridz = 1;
		var dbcr = 'Cash';
		$.post('jabaproviout/php/insert_salespayment_proviout.php',{var_invidz:var_invidz,dbcridz:dbcridz,dbcr:dbcr,amt:amt,var_invno:var_invno,var_payable:var_payable,var_chkdate:var_chkdate,var_soldtoidz:var_soldtoidz,var_delinfonameidxx:var_delinfonameidxx,branch: branchidxx},function(result){
			$("#receiver").html(result);
			getsalespayment();
		});
	});

	$("#print_receipt").on("click", function (e) {
		if (branchidxx == 7) {
			$("#lucbr").css("display", "block");
		} else if (branchidxx == 8 || branchidxx == 0) {
			$("#psjbr").css("display", "block");
		}

		if(var_payable > 0)
		{
			msg ="Cant be print. Still have payable amount";
			$(".modal").modal('hide');
			shownotif(msg,3);
		}
		else if(var_itemcount <= 0)
		{
			msg ="Empty Transaction";
			$(".modal").modal('hide');
			shownotif(msg,3);
		}
		else
		{
			$(".modal").modal('hide');
			saved();
			
			$("#save_cash_tendered").removeClass('d-none');
			$("#print_receipt").addClass('d-none');
		}
	});

	function setbankname(bankname,bankid)
	{
		var_bankname = bankname;
		$("#txt_bankname").val(var_bankname);
		$("#txt_bankreference").val("");
		var_bankreference = "";
		var_bankid = bankid;
		$("#txt_bankreference").focus();
		$("#txt_bankreference").select();
	}

	$("#txt_bankreference").on("change", function(e){
		$("#txt_creditcard").focus();
		$("#txt_creditcard").select();
	});

	// $("#txt_creditcard").on("change", function(e){
	$("#btn_save_bank_payt").on("click", function (e) {
		var amt = $("#txt_creditcard").val();
		if(var_payable < amt)
		{
			msg = "Amount higher than payable";
			$(".modal").modal('hide');
			shownotif(msg,3);
			return;
		}
		if(amt <= 0)
		{
			msg = "Invalid Amount";
			$(".modal").modal('hide');
			shownotif(msg,3);
			return;
		}
		var_bankreference = $("#txt_bankreference").val();
		var_delinfonameidxx = 0;
		var_soldtodelinfo = "";
		var_chkdate = formatDate(new Date());
		$("#btn_save_bank_payt").addClass('d-none');
		$("#btn_save_bank_print").removeClass('d-none');

		$("#txt_creditcard").prop('disabled', true);
		var dbcridz = 3;
		var dbcr = var_bankreference.substr(-8);

		$.post('jabaproviout/php/insert_salespayment_proviout.php',{var_invidz:var_invidz,dbcridz:dbcridz,dbcr:dbcr,amt:amt,var_invno:var_invno,var_payable:var_payable,var_chkdate:var_chkdate,var_soldtoidz:var_soldtoidz,var_delinfonameidxx:var_delinfonameidxx,var_bankname:var_bankname,var_bankid:var_bankid,var_bankreference:var_bankreference,branch: branchidxx},function(result){
			$("#receiver").html(result);
			getsalespayment();
		});
	});

	$("#btn_save_bank_print").on("click", function (e) {
		if (branchidxx == 7) {
			$("#lucbr").css("display", "block");
		} else if (branchidxx == 8 || branchidxx == 0) {
			$("#psjbr").css("display", "block");
		}
		
		$(".modal").modal('hide');
		saved();

		$("#btn_save_bank_payt").removeClass('d-none');
		$("#btn_save_bank_print").addClass('d-none');
	});

	//SAVING
	function saved()
	{
		$("#printview").html(loadGifprint);
		$('#btn_print_push').prop('disabled', true);

		$.post("jabaproviout/php/save_proviout.php",{var_pridz:var_pridz,var_invidz:var_invidz,var_couponidxx:var_couponidxx,branch: branchidxx},function(result){
			if(result == 1)
			{
				saved();
			}
			else
			{
				$('#modal_print').modal({
					backdrop: 'static',
					keyboard: false
				})
				printrefresh();
			}
		});
	}

	function printrefresh()
	{
		$.post("jabaproviout/php/print_proviout_newReceipt.php",{var_pridz:var_pridz,var_invidz:var_invidz,var_invno:var_invno,cashiername:cashiername,datenow:datenow,var_soldtoname:var_soldtoname,var_soldtodelinfo:var_soldtodelinfo,branch: branchidxx},function(result){
			$("#printview").html(result);
			$('#btn_print_push').prop('disabled', false);
		});

		$("#modal_print").modal("show");
	}

	$("#btn_print_push").click(function(e){
		var divToPrint = document.getElementById('printviewouter').innerHTML;
		var currentDate = new Date().toISOString().slice(0,10).replace(/-/g,"");
    		var pdfFileName = "Jaba_Receipt_" + currentDate + ".pdf";
		var newWin = window.open('', 'Print-Window');
		newWin.document.open();
		newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="stylesheets/printform.css"></head><body onload="window.print()">' + divToPrint + '</body></html>');
		newWin.document.title = pdfFileName;
		newWin.document.close();
		setTimeout(function() {
			newWin.close();
			$("#modal_print").modal("hide");
			init();
		}, 100);
	});

	//OTHERS
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

	function isDoubleClicked(element) {
		if (element.data("isclicked")) return true;
		element.data("isclicked", true);
		setTimeout(function () {
			element.removeData("isclicked");
		}, 1000);
		return false;
	}

	function formatDate(date) {
	var d = new Date(date),
		month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
	}

	function getCharsBefore(str) {
		var index = str.indexOf("@");
		if (index != -1) {
			return(str.substring(0, index));
			}
		return("");
	}

	function getCharsafter(str) {
		return str.split('@')[1];
	}


	//autofocus
	document.addEventListener("keypress", function(e) {
	  if (e.target.tagName !== "INPUT" && e.keyCode !== 13) {
		var input = document.getElementById ("txt_barcode");
		input.focus();
		input.value = e.key;
		e.preventDefault();
	  }
	});

	document.onkeyup = function(e) {
		if(e.altKey && e.which == 51)
		{
			if($('.modal').hasClass('in'))
			{

			}
			else
			{
				$("#changetype").modal('show');
				gettypedetails();
			}
		}
		//P
		else if(e.altKey && e.which == 80)
		{
			if(var_payable > 0)
			{
				msg ="Cant be print. Still have payable amount";
				$(".modal").modal('hide');
				shownotif(msg,3);
			}
			else if(var_itemcount <= 0)
			{
				msg ="Empty Transaction";
				$(".modal").modal('hide');
				shownotif(msg,3);
			}
			else
			{
				$(".modal").modal('hide');
				if(var_fordelstatus == 0)
				{
					saved();
				}
				else
				{
					if(var_soldtoidz == 1)
					{
						$("#modal_adddelinfofordel").modal('show');
						loadcontactnofordel();
					}
					else
					{
						saved();
					}
				}
				
			}
		}
	};

	// WHEN ESC ISNT WORKING, THE MANUALLY CLOSE IT.
	$(document).ready(function() {
		$("#btn_close_print").on("click", function() {
			$("#modal_print").modal('hide');
			$('.modal').modal('hide');
			init();
		});

		if ($('#modal_print').is(':visible'))
		{
			document.onkeyup = function(e) {
				//ESC
				if(e.altKey && e.which == 27) {
					$("#modal_print").modal('hide');
					$('.modal').modal('hide');
					init();
				}
			}
		}
	});

</script>