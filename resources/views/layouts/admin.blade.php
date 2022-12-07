<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Sistem Informasi Logistik Digital
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../assets/demo/demo.css" rel="stylesheet" />
  <style>
    input[type="date"]::-webkit-calendar-picker-indicator {
    background: transparent;
    bottom: 0;
    color: transparent;
    cursor: pointer;
    height: auto;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    width: auto;
}
    </style>
</head>

<body class="">
  <div class="wrapper ">
    @yield('admin.content')
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="../assets/js/plugins/chartjs.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
  {{-- <script src="../assets/demo/demo.js"></script> --}}
  <script type="text/javascript">
  		
    // var valbil = document.getElementById('admin-billing-net-value');
		// valbil.addEventListener('keyup', function(e){
		// 	rupiah.value = formatRupiah(this.value, 'Rp. ');
		// });

		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}

   </script>

  <script>

    $('#admin-inquiry').change(function () {
        $.getJSON("/admin/dropdown/inquiry/" + $(this).val(), function (data) {
          $('#quotation-material-name').val(data.material_name);
          $('#quotation-order-quantity').val(data.order_quantity);
          $('#quotation-order-quantity').val(data.order_quantity);
          $('#admin-quotation-net-value').val(formatRupiah(data.order_quantity * data.material_price , 'Rp. '));
          $('#quotation-material-description').val(data.description);
        });
    });

    $('#admin-purchase-order').change(function () {
        $.getJSON("/admin/dropdown/purchase-order/" + $(this).val(), function (data) {
          $('#sales-order-distribution-channel').val(data.distribution_channel);
          
          var location2 = $('#sales-order-company-name');
          location2.empty();
          location2.append("<option value='" + data.company_id + "' selected>  (C-0"+data.company_id+") "+data.company_name +"</option>");
                   
          var location2 = $('#sales-order-material');
          location2.empty();
          location2.append("<option value='" + data.material_id + "' selected>  (M-0"+data.material_id+") "+data.material_name +"</option>");

          $('#sales-order-quamtity').val(data.quantity);
          $('#sales-order-description').val(data.description);
        });
    });

    $('#admin-sales-order').change(function () {
        $.getJSON("/admin/dropdown/sales-order/" + $(this).val(), function (data) {
          $('#outbound-delivery-customer').val("C-0"+data.customer_id+" "+data.customer_name);
          $('#outbound-delivery-req-delivery-date').val(data.req_delivery_date);
          $('#outbound-delivery-material').val("M-0"+data.material_id+" "+data.material_name);
          $('#outbound-delivery-quantity').val(data.quantity);
          $('#outbound-delivery-description').val(data.description);
          $('#outbound-warehouse-number').val(data.warehouse_number);
        });
    });

    $('#admin-outbound-delivery').change(function () {
        $.getJSON("/admin/dropdown/outbound-delivery/" + $(this).val(), function (data) {
          $('#billing_document_customer').val("C-0"+data.customer_id+" "+data.customer_name);
          $('#outbound-delivery-material-name').html("(M-0" + data.material_id + ") "+ data.material_name);
          $('#outbound-delivery-material-description').html(data.description);
          $('#outbound-delivery-quantity').html(data.quantity);
          $('#outbound-delivery-amount').html(formatRupiah(data.net_value , 'Rp. '));
          $('#outbound-val-material_id').val(data.material_id);
          $('#admin-billing-net-value').val(formatRupiah(data.net_value , 'Rp. '));
          $('#outbound-val-billed_quantity').val(data.quantity);
        });
    });

    $('#accounting-billing-document-dropdown').change(function () {
        $.getJSON("/admin/dropdown/accounting-document/" + $(this).val(), function (data) {
          $('#billing_document_customer').val("C-0"+data.customer_id+" "+data.customer_name);
          $('#accounting-document-dropdown').val("AD-0"+data.id);
        });
    });

  </script>
</body>

</html>
