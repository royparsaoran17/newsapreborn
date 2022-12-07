@extends('layouts.users')

@section('users.content')
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
                <a href="{{url('user/inquiry')}}">
                    <i class="nc-icon nc-app"></i>
                    <p>Inquiry</p>
                </a>
            </li>
            <li>
                <a href="{{url('user/quotation')}}">
                    <i class="nc-icon nc-check-2"></i>
                    <p>Quotation</p>
                </a>
            </li>
            <li>
                <a href="{{url('user/purchase-order')}}">
                    <i class="nc-icon nc-cart-simple"></i>
                    <p>Purchase Order</p>
                </a>
            </li>
            <li class="active">
                <a href="{{url('user/payment')}}">
                    <i class="nc-icon nc-single-copy-04"></i>
                    <p>Payment</p>
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
                <a class="navbar-brand" href="javascript:;">USER DASHBOARD</a>
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
                        <h5 class="card-title">Add Payment</h5>
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
                        <form action="{{ route('payment.action') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"  style="text-align: center">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="green" class="bi bi-check" viewBox="0 0 16 16">
                                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                          </svg>
                                          <h5 class="modal-title" id="exampleModalLongTitle">Payment Success</h5>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                  </div>
                                </div>
                              </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Billing Document</label>
                                        <select class="form-control" aria-label="Default select example" name="billing_id" id="user-payment-billing">
                                            <option selected></option>@foreach ($billing as $key)
                                            <option value="{{$key->id}}">B-0{{$key->id}}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @if($flagPayment == true)
                            <input type="hidden" id="flagPayment" value="1">
                            @endif
                            @if($flagPayment == false)
                            <input type="hidden" id="flagPayment" value="2">
                            @endif
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Billing Report</label>
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="hidden" name="company_id" id="user-payment-company-id">
                                        <select class="form-control" aria-label="Default select example" name="company_id" disabled id="user-payment-company">
                                            <option selected></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="payment-material-name">
                                                    </td>
                                                    <td id="payment-material-description">
                                                    </td>
                                                    <td id="payment-quantity">
                                                    </td>
                                                    <td id="payment-amount">
                                                    </td>
                                                </tr>
                                                <tr style="background-color:lightgrey">
                                                    <th colspan="3" style="text-align:center">
                                                        Total Amount
                                                    </th>
                                                    <td id="payment-amount-2">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5>Bank Data</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bank Account</label>
                                        <input type="text" class="form-control" name="bank_account">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select class="form-control" aria-label="Default select example" name="payment_method">
                                            <option selected></option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="Cash">Cash</option>
                                            <option value="Credit">Credit</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="update ml-auto mr-auto">
                                    <button type="submit" class="btn btn-primary btn-round">Pay Now</button>
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

{{-- 
<script>
    var valquo = document.getElementById('user-payment');
    valquo.addEventListener('keyup', function(e){
        valquo.value = formatRupiah(this.value, 'Rp. ');
    });
</script> --}}

@endsection
