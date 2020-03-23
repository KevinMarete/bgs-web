<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Checkout</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    @if (Session::has('bgs_msg'))
        {!! session('bgs_msg') !!}
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg ">
                        <div class="row mx-auto justify-content-center text-center">
                            <div class="col-12 mt-3">
                                <nav aria-label="breadcrumb" class="second ">
                                    <ol class="breadcrumb indigo lighten-6 first ">
                                        <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="/{{ $back_to_link }}"><span class="mr-md-3 mr-1">BACK TO SHOPPING</span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
                                        <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase" href="/cart"><span class="mr-md-3 mr-1">SHOPPING CART</span></a><i class="fa fa-angle-double-right text-uppercase " aria-hidden="true"></i></li>
                                        <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase active-2" href="#"><span class="mr-md-3 mr-1">CHECKOUT</span></a></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="row justify-content-around">
                            <div class="col-md-6">
                                <div class="card border-0">
                                    <div class="card-header pb-0">
                                        <p class="card-text text-muted mt-4 space">SHIPPING DETAILS</p>
                                        <hr class="my-0">
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-between">
                                            <div class="col-auto mt-0">
                                                <address>
                                                    <strong>{{ session()->get('organization.name') }}</strong><br>
                                                    {{ session()->get('organization.building') }}<br>
                                                    {{ session()->get('organization.road') }}, {{ session()->get('organization.town') }}, Kenya<br>
                                                    <abbr title="Phone">Phone:</abbr> (+254) {{ session()->get('phone') }}
                                                    <abbr title="email">Email:</abbr> {{ session()->get('email') }}
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col">
                                                <p class="text-muted mb-2">PAYMENT DETAILS</p>
                                                <hr class="mt-0">
                                            </div>
                                        </div>
                                        <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active show" data-toggle="pill" href="#nav-tab-card">
                                                <i class="fa fa-credit-card"></i> Debit/Credit Card</a></li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#nav-tab-mobile">
                                                <i class="fa fa-university"></i>  Mobile Money</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="nav-tab-card">
                                                <form role="form" action="/save-order/card" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="username">Full name (on the card)</label>
                                                        <input type="text" class="form-control" name="card_name" required>
                                                    </div> <!-- form-group.// -->

                                                    <div class="form-group">
                                                        <label for="cardNumber">Card number</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="card_number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text text-muted">
                                                                    <i class="fab fa-cc-visa"></i> &nbsp; <i class="fab fa-cc-amex"></i> &nbsp; 
                                                                    <i class="fab fa-cc-mastercard"></i> 
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div> <!-- form-group.// -->

                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="form-group">
                                                                <label><span class="hidden-xs">Expiration</span> </label>
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control" placeholder="MM" name="expiry_month" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                                                    <input type="text" class="form-control" placeholder="YY" name="expiry_year" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                                <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                                                <input type="text" class="form-control" name="cvv_code" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                                            </div> <!-- form-group.// -->
                                                        </div>
                                                    </div> <!-- row.// -->
                                                    <button type="submit" name="" id="" class="btn btn-lg btn-block btn-primary">PURCHASE</button>
                                                </form>
                                            </div> <!-- tab-pane.// -->
                                            <div class="tab-pane fade" id="nav-tab-mobile">
                                                <form role="form" action="/save-order/mobile" method="POST">
                                                    @csrf
                                                    <p>Mobile Money Details</p>
                                                    <dl class="param">
                                                        <dt>Paybill Number: </dt>
                                                        <dd>{{ $paybill_number }}</dd>
                                                    </dl>
                                                    <dl class="param">
                                                        <dt>Account number: </dt>
                                                        <dd>{{ $account_number }}</dd>
                                                    </dl>
                                                    <dl class="param">
                                                        <dt>Phone number: </dt>
                                                        <dd> 
                                                            <input type="hidden" class="form-control" name="paybill_number" value="{{ $paybill_number }}">
                                                            <input type="hidden" class="form-control" name="account_number" value="{{ $account_number }}">
                                                            <input type="text" name="phone" value="{{ session()->get('phone') }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required/> 
                                                        </dd>
                                                    </dl>
                                                    <p><strong>Note:</strong> Additional transaction costs will be charged</p>
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Pay Now</button>
                                                </form>
                                            </div> <!-- tab-pane.// -->
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 ">
                                    <div class="card-header card-2">
                                        <p class="card-text text-muted mt-md-4 mb-2 space">YOUR ORDER DETAILS</p>
                                        <hr class="my-2">
                                    </div>
                                    <div class="card-body pt-0">
                                        @foreach ($cart_items as $cart_item)
                                            <div class="row justify-content-between">
                                                <div class="col-auto col-md-7">
                                                    <div class="media flex-column flex-sm-row"> <img class="img-fluid" src="/assets/img/medicine.png" width="50" height="50">
                                                        <div class="media-body my-auto">
                                                            <div class="row ">
                                                                <div class="col-auto">
                                                                    <p class="mb-0"><b>{{ $cart_item['product_name'] }}</b></p><small class="text-muted">{{ $cart_item['product_description'] }}</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" pl-0 flex-sm-col col-auto my-auto">
                                                    <p class="boxed-1">{{ number_format($cart_item['quantity']) }}</p>
                                                </div>
                                                <div class=" pl-0 flex-sm-col col-auto my-auto ">
                                                    <p><b>{{ number_format($cart_item['sub_total']) }} KES</b></p>
                                                    <input type="hidden" value="{{ $total += $cart_item['sub_total'] }}"/>
                                                    <input type="hidden" value="{{ $shipping += ($cart_item['delivery']*$cart_item['quantity']) }}"/>
                                                </div>
                                            </div>
                                            <hr class="my-2">
                                        @endforeach
                                        <div class="row ">
                                            <div class="col">
                                                <div class="row justify-content-between">
                                                    <div class="col-4">
                                                        <p class="mb-1"><b>Subtotal</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>{{ number_format($total) }} KES</b></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <p class="mb-1"><b>Shipping</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>{{ number_format($shipping) }} KES</b></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col-4">
                                                        <p><b>Total</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>{{ number_format($total + $shipping) }} KES</b></p>
                                                    </div>
                                                </div>
                                                <hr class="my-0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>