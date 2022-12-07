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

            <li>
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
            <li class="active">
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
                        <h5 class="card-title">Display Accounting Document</h5>
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
                        <form action="{{ route('accounting_document.action') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Billing Document</label>
                                        <select class="form-control" aria-label="Default select example" id="accounting-billing-document-dropdown" name="billing_id">
                                            <option selected></option>
                                            @foreach ($data as $key)
                                            <option value="{{$key->id}}"> B-0{{$key->id}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Accounting Document Number</label>
                                        <input type="text" class="form-control" disabled id="accounting-document-dropdown">
                                    </div>
                                </div>
                            </div>
                            <br>
                            @if ($flag == false)
                            <div class="row" hidden>
                            @else
                            <div class="row">
                            @endif
                                <div class="col-md-12">
                                    <h5>Material Details</h5>
                                    <hr>
                                    <p></p>
                                    <p>Customer ID : C-0{{$billing->customer_id}} </p>
                                    <p>Customer Name : {{$billing->user_name}}</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    Material Name
                                                </th>
                                                <th>
                                                    Description
                                                </th>
                                                <th>
                                                    Quantity
                                                </th>
                                                <th>
                                                    Amount
                                                </th>
                                                <th>
                                                    
                                                </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        M-0{{$billing->material_id}} {{$billing->material_name}}
                                                    </td>
                                                    <td>
                                                        {{$billing->description}}
                                                    </td>
                                                    <td>
                                                        {{$billing->billed_quantity}}
                                                    </td>
                                                    <td>
                                                    {{"Rp " . number_format($billing->net_value,0,',','.')}}
                                                    </td>
                                                </tr>          
                                                <tr style="background-color:lightgrey">
                                                    <th colspan="3" style="text-align:center">
                                                        Total Amount
                                                    </th>
                                                    <td>
                                                    {{"Rp " . number_format($billing->net_value,0,',','.')}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary btn-round">OK</button>
                                </div>
                            </div>
                        </form>
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
                        © <script>
                            document.write(new Date().getFullYear())

                        </script>
                    </span>
                </div>
            </div>
        </div>
    </footer>
</div>

@endsection
