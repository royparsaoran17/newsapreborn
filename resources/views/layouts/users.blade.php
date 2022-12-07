<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Sistem Informasi Logistik Digital</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <!-- <link href="../assets/demo/demo.css" rel="stylesheet" /> -->
</head>

<body class="">
    <div class="wrapper ">
        @yield('users.content')
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
    <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <!-- <script src="../assets/demo/demo.js"></script> -->
    <script type="text/javascript">
  		
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
        $('#sidebar-user a').click(function () {
            $('#sidebar-user a').removeClass('active');
            $(this).addClass('active');
        })

        $('#inquiry-company').change(function () {
            $.getJSON("/dropdown/company/" + $(this).val(), function (data) {
                var location = $('#inquiry-company-distribution');
                location.empty();
                location.append("<option value='" + data.id + "' selected>" + data.distribution_channel +"</option>");
            });
        });

        $('#inquiry-material').change(function () {
            $.getJSON("/dropdown/material/" + $(this).val(), function (data) {
                var location = $('#inquiry-material-description');
                location.empty();
                location.val(data.description)
            });
        });

        $('#user-inquiry-po').change(function () {
            console.log("3");
            $.getJSON("/dropdown/inquiry/" + $(this).val(), function (data) {
                var location = $('#inquiry-company-po');
                location.empty();
                location.append("<option value='" + data.company_id + "' selected> (C-0"+data.company_id+") "+data.company_name +"</option>");
                
                var location2 = $('#inquiry-material-po');
                location2.empty();
                location2.append("<option value='" + data.material_id + "' selected>  (M-0"+data.material_id+") "+data.material_name +"</option>");
                $('#inquiry-po-quantity').val(data.order_quantity);
            });
        });

        $('#user-quotation').change(function () {
            $.getJSON("/dropdown/quotation/" + $(this).val(), function (data) {
                $('#quotation-company').val(data.company_name);
                $('#quotation-distribution').val(data.distribution_channel);
                $('#quotation-valid-from').val(data.valid_from);
                $('#quotation-valid-to').val(data.valid_to);
                $('#quotation-net-value').val(formatRupiah(data.net_value, 'Rp. '));
                $('#quotation-material').val("M-0" + data.material_id + " " + data.material_name);
                $('#quotation-quantity').val(data.order_quantity);
                $('#quotation-material-description').val(data.description);
            });
        });

        $('#user-payment-billing').change(function () {
            $.getJSON("/dropdown/billing-document/" + $(this).val(), function (data) {
                $('#payment-material-name').html("(M-0" + data.material_id + ") "+ data.material_name);
                $('#payment-material-description').html(data.description);
                $('#payment-quantity').html(data.billed_quantity);
                $('#payment-amount').html(formatRupiah(data.net_value, 'Rp. '));
                $('#payment-amount-2').html(formatRupiah(data.net_value, 'Rp. '));
                $('#user-payment-company-id').val(data.company_id);

                var location = $('#user-payment-company');
                location.empty();
                location.append("<option value='" + data.company_id + "' selected> (C-0" + data.company_id +") "+data.company_name+"</option>");
            });
        });

        $(window).on('load', function() {
            var x = document.getElementById("flagPayment").value;
            if(x == 1){
                $('#exampleModalCenter').modal('show');
            }
        });  
    </script>
</body>

</html>
