@extends('layouts.admin')
@section('admin.content')
<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="" class="simple-text logo-mini">
            <div class="logo-image-small">
            </div>
        </a>
        <a href="" class="simple-text logo-normal">
            Sistem Informasi<br>
Logistik Digital
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">

            <li class="active">
                <a href="{{url('quotation')}}">
                    <i class="nc-icon nc-check-2"></i>
                    <p>Quotation</p>
                </a>
            </li>
            <li>
                <a href="{{url('sales-order')}}">
                    <i class="nc-icon nc-single-copy-04"></i>
                    <p>Sales Order</p>
                </a>
            </li>
            <li>
                <a href="{{url('outbound-delivery')}}">
                    <i class="nc-icon nc-delivery-fast"></i>
                    <p>Outbound Delivery</p>
                </a>
            </li>
            <li>
                <a href="{{url('transfer-order')}}">
                    <i class="nc-icon nc-email-85"></i>
                    <p>Transfer Order</p>
                </a>
            </li>
            <li>
                <a href="{{url('stock-overview')}}">
                    <i class="nc-icon nc-tile-56"></i>
                    <p>Stock Overview</p>
                </a>
            </li>
            <li>
                <a href="{{url('material-purchasing')}}">
                    <i class="nc-icon nc-simple-add"></i>
                    <p>Material Purchasing</p>
                </a>
            </li>

            <li>
                <a href="{{url('billing-document')}}">
                    <i class="nc-icon nc-tablet-2"></i>
                    <p>Billing Document</p>
                </a>
            </li>
            <li>
                <a href="{{url('accounting-document')}}">
                    <i class="nc-icon nc-paper"></i>
                    <p>Accounting Document</p>
                </a>
            </li>
            <li>
                <a href="{{url('incoming-payment')}}">
                    <i class="nc-icon nc-money-coins"></i>
                    <p>Incoming Payment</p>
                </a>
            </li>
            <li>
                <a href="{{url('document-flow')}}">
                    <i class="nc-icon nc-vector"></i>
                    <p>Document Flow</p>
                </a>
            </li>
            <li>
                <a href="{{url('report')}}">
                    <i class="nc-icon nc-credit-card"></i>
                    <p>Report</p>
                </a>
            </li>
            <li>
                <a href="{{url('logs')}}">
                    <i class="nc-icon nc-app"></i>
                    <p>Log</p>
                </a>
            </li>
        </ul>

    </div>
</div>
<div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <a class="navbar-brand" href="javascript:;">ADMIN DASHBOARD</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
                <span class="navbar-toggler-bar navbar-kebab"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navigation">
                <ul class="navbar-nav">
                    <li class="nav-item btn-rotate dropdown">
                        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nc-icon nc-settings-gear-65"></i>
                            <p>
                                <span class="d-lg-none d-md-block">Some Actions</span>
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{url('logout')}}">Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <!-- CONTENT -->
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-user">
                    <div class="card-header">
                        <h5 class="card-title">Create Quotation With Reference Inquiry (Overview)</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                        @foreach($errors->all() as $err)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="nc-icon nc-simple-remove"></i>
                            </button>
                            <span>{{ $err }}</span>
                          </div>
                        @endforeach
                        @endif
                        <form action="{{ route('quotation.action') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Inquiry</label>
                                        <select class="form-control" aria-label="Default select example" name="inquiry_id" id="admin-inquiry">   
                                            <option selected></option>              
                                            @foreach ($inquiry as $key)
                                            <option value="{{$key->id}}">I - 0{{$key->id}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h5>Customer Data</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select class="form-control" aria-label="Default select example" name="customer_id" required>
                                            <option selected></option>
                                            @foreach ($users as $key)
                                            <option value="{{$key->id}}">{{$key->id}} - {{$key->name}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <h5>Material Detail</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valid From</label>
                                        <input type="date" class="form-control" name="valid_from">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valid To</label>
                                        <input type="date" class="form-control" name="valid_to">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Net Value</label>
                                        <input type="text" class="form-control" name="net_value" id="admin-quotation-net-value">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Material Name</label>
                                        <input type="text" class="form-control" disabled id="quotation-material-name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Order Quantity</label>
                                        <input type="number" class="form-control" disabled id="quotation-order-quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" disabled id="quotation-material-description">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary btn-round">Create Quotation</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> View Quotation</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Quotation Number
                                    </th>
                                    <th>
                                        Customer
                                    </th>
                                    <th>
                                        Material Name
                                    </th>
                                    <th>
                                        Order Quantity
                                    </th>
                                    <th>
                                        Valid From
                                    </th>
                                    <th>
                                        Valid To
                                    </th>
                                    <th>
                                        Net Value
                                    </th>
                                    <th>
                                        
                                    </th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key)
                                    <tr>
                                        <td>
                                            Q-0{{$key->id}}
                                        </td>
                                        <td>
                                            C-0{{$key->customer_id}} - {{$key->user_name}}
                                        </td>
                                        <td>
                                            M-0{{$key->material_id}} - {{$key->material_name}}
                                        </td>
                                        <td>
                                            {{$key->order_quantity}}
                                        </td>
                                        </td>
                                        <td>
                                            {{$key->valid_from}}
                                        </td>
                                        <td>
                                            {{$key->valid_to}}
                                        </td>
                                        <td>
                                            {{"Rp " . number_format($key->net_value,0,',','.')}}
                                        </td>

                                        <td style="text-align: center">
                                            <div class="update ml-auto mr-auto">
                                                <form action="{{ URL('quotation/'.$key->id.'/delete') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <button type="submit"
                                                        class="btn btn-danger btn-round">Delete</button>
                                                </form>
                                            </div>
                                        </td>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- END CONTENT -->

    <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
            <div class="row">
                <div class="credits ml-auto">
                    <span class="copyright">
                        ?? <script>
                            document.write(new Date().getFullYear())
                        </script>
                    </span>
                </div>
            </div>
        </div>
    </footer>
</div>

{{-- <script>
    var valquo = document.getElementById('admin-quotation-net-value');
    valquo.addEventListener('keyup', function(e){
        valquo.value = formatRupiah(this.value, 'Rp. ');
    });
</script> --}}

@endsection
