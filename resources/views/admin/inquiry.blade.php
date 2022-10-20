@extends('layouts.admin')
@section('admin.content')
<div class="sidebar" data-color="white" data-active-color="danger">
    <div class="logo">
        <a href="" class="simple-text logo-mini">
            <div class="logo-image-small">
            </div>
        </a>
        <a href="" class="simple-text logo-normal">
            SAP REBORN
        </a>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="active">
                <a href="{{url('inquiry')}}">
                    <i class="nc-icon nc-app"></i>
                    <p>Inquiry</p>
                </a>
            </li>
            <li>
                <a href="{{url('quotation')}}">
                    <i class="nc-icon nc-check-2"></i>
                    <p>Quotation</p>
                </a>
            </li>
            <li>
                <a href="{{url('purchase-order')}}">
                    <i class="nc-icon nc-cart-simple"></i>
                    <p>Purchase Order</p>
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
                        <h5 class="card-title">Add Inquiry</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Company</label>
                                        <select class="form-control" aria-label="Default select example">
                                            <option selected></option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Customer</label>
                                        <select class="form-control" aria-label="Default select example">
                                            <option selected></option>
                                            <option value="1">17772033 - Roy Parsaoran</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Material</label>
                                        <select class="form-control" aria-label="Default select example">
                                            <option selected></option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Distribution Channel</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Order Quantity</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Desciption</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary btn-round">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Inquiry</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Country
                                    </th>
                                    <th>
                                        City
                                    </th>
                                    <th class="text-right">
                                        Salary
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Dakota Rice
                                        </td>
                                        <td>
                                            Niger
                                        </td>
                                        <td>
                                            Oud-Turnhout
                                        </td>
                                        <td class="text-right">
                                            $36,738
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Minerva Hooper
                                        </td>
                                        <td>
                                            Curaçao
                                        </td>
                                        <td>
                                            Sinaai-Waas
                                        </td>
                                        <td class="text-right">
                                            $23,789
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sage Rodriguez
                                        </td>
                                        <td>
                                            Netherlands
                                        </td>
                                        <td>
                                            Baileux
                                        </td>
                                        <td class="text-right">
                                            $56,142
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Philip Chaney
                                        </td>
                                        <td>
                                            Korea, South
                                        </td>
                                        <td>
                                            Overland Park
                                        </td>
                                        <td class="text-right">
                                            $38,735
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Doris Greene
                                        </td>
                                        <td>
                                            Malawi
                                        </td>
                                        <td>
                                            Feldkirchen in Kärnten
                                        </td>
                                        <td class="text-right">
                                            $63,542
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Mason Porter
                                        </td>
                                        <td>
                                            Chile
                                        </td>
                                        <td>
                                            Gloucester
                                        </td>
                                        <td class="text-right">
                                            $78,615
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Jon Porter
                                        </td>
                                        <td>
                                            Portugal
                                        </td>
                                        <td>
                                            Gloucester
                                        </td>
                                        <td class="text-right">
                                            $98,615
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
