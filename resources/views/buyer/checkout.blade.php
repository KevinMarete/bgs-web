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
    <div class="card mb-4">
        <!--
        <div class="card-header"> 
            <div class="row mx-auto justify-content-center text-center">
                <nav aria-label="breadcrumb" class="second ">
                    <ol class="breadcrumb indigo lighten-6 first ">
                        <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="/ordernow"><span class="mr-md-3 mr-1">BACK TO SHOPPING</span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
                        <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase" href="/cart"><span class="mr-md-3 mr-1">SHOPPING CART</span></a><i class="fa fa-angle-double-right text-uppercase " aria-hidden="true"></i></li>
                        <li class="breadcrumb-item font-weight-bold"><a class="black-text text-uppercase active-2" href="#"><span class="mr-md-3 mr-1">CHECKOUT</span></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        -->
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg ">
                        <div class="row mx-auto justify-content-center text-center">
                            <div class="col-12 mt-3">
                                <nav aria-label="breadcrumb" class="second ">
                                    <ol class="breadcrumb indigo lighten-6 first ">
                                        <li class="breadcrumb-item font-weight-bold "><a class="black-text text-uppercase " href="/ordernow"><span class="mr-md-3 mr-1">BACK TO SHOPPING</span></a><i class="fa fa-angle-double-right " aria-hidden="true"></i></li>
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
                                                    <strong>Malibu Chemist</strong><br>
                                                    4th Floor Lonrho House<br>
                                                    Kenyatta Avenue, Nairobi, Kenya<br>
                                                    <abbr title="Phone">Phone:</abbr> (+254) 722123456
                                                    <abbr title="email">Email:</abbr> malibu@gmail.com
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
                                                <form role="form" action="/card-subscription" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="username">Full name (on the card)</label>
                                                        <input type="hidden" class="form-control subscription-package" name="package_id">
                                                        <input type="hidden" class="form-control subscription-price" name="price">
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
                                                    <button type="submit" name="" id="" class="btn btn-lg btn-block btn-primary">PURCHASE 37 KES</button>
                                                </form>
                                            </div> <!-- tab-pane.// -->
                                            <div class="tab-pane fade" id="nav-tab-mobile">
                                                <form role="form" action="/mobile-subscription" method="POST">
                                                    @csrf
                                                    <p>Mobile Money Details</p>
                                                    <dl class="param">
                                                        <dt>Paybill Number: </dt>
                                                        <dd> </dd>
                                                    </dl>
                                                    <dl class="param">
                                                        <dt>Account number: </dt>
                                                        <dd> </dd>
                                                    </dl>
                                                    <dl class="param">
                                                        <dt>Phone number: </dt>
                                                        <dd> </dd>
                                                    </dl>
                                                    <p><strong>Note:</strong> Additional transaction costs will be charged</p>
                                                    <button class="btn btn-lg btn-primary btn-block" type="submit">Pay Now 37 KES</button>
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
                                        <div class="row justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row"> <img class=" img-fluid" src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                    <div class="media-body my-auto">
                                                        <div class="row ">
                                                            <div class="col-auto">
                                                                <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">1 Week Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto my-auto">
                                                <p class="boxed-1">2</p>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto my-auto ">
                                                <p><b>179 KES</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row"> <img class=" img-fluid " src="https://i.imgur.com/9MHvALb.jpg" width="62" height="62">
                                                    <div class="media-body my-auto">
                                                        <div class="row ">
                                                            <div class="col">
                                                                <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto my-auto">
                                                <p class="boxed">3</p>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto my-auto">
                                                <p><b>179 KES</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row"> <img class=" img-fluid " src="https://i.imgur.com/6oHix28.jpg" width="62" height="62">
                                                    <div class="media-body my-auto">
                                                        <div class="row ">
                                                            <div class="col">
                                                                <p class="mb-0"><b>EC-GO Bag Standard</b></p><small class="text-muted">2 Week Subscription</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto my-auto">
                                                <p class="boxed-1">2</p>
                                            </div>
                                            <div class="pl-0 flex-sm-col col-auto my-auto">
                                                <p><b>179 KES</b></p>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="row ">
                                            <div class="col">
                                                <div class="row justify-content-between">
                                                    <div class="col-4">
                                                        <p class="mb-1"><b>Subtotal</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>179 KES</b></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col">
                                                        <p class="mb-1"><b>Shipping</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>0 KES</b></p>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-between">
                                                    <div class="col-4">
                                                        <p><b>Total</b></p>
                                                    </div>
                                                    <div class="flex-sm-col col-auto">
                                                        <p class="mb-1"><b>537 KES</b></p>
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