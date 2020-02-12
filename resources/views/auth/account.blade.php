<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="user"></i></div>
                <span>Account</span>
            </h1>
            <div class="sb-page-header-subtitle">Manage User Account, Password and Subscription</div>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">Manage Account</div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="" data-target="#password" data-toggle="tab" class="nav-link">Password</a>
                            </li>
                            <li class="nav-item">
                                <a href="" data-target="#subscription" data-toggle="tab" class="nav-link">Subscription</a>
                            </li>
                        </ul>
                        <div class="tab-content py-4">
                            <div class="tab-pane active" id="profile">
                                <form role="form">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Firstname</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Lastname</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Organization</label>
                                        <div class="col-lg-9">
                                            <select class="form-control" size="0" disabled>
                                                <option value="">Select Organization</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="email" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Phone</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="text" value="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label"></label>
                                        <div class="col-lg-9">
                                            <input type="reset" class="btn btn-secondary" value="Cancel">
                                            <input type="button" class="btn btn-primary" value="Update Profile">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="password">
                                <form role="form">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Current Password</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="password" value="11111122333">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">New Password</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="password" value="11111122333">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                                        <div class="col-lg-9">
                                            <input class="form-control" type="password" value="11111122333">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label form-control-label"></label>
                                        <div class="col-lg-9">
                                            <input type="reset" class="btn btn-secondary" value="Cancel">
                                            <input type="button" class="btn btn-primary" value="Change Password">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="subscription">
                                <!--subscription options-->
                                <div class="container">
                                    <div class="card-deck mb-3 text-center">
                                        <div class="card mb-4 box-shadow">
                                        <div class="card-header">
                                            <h4 class="my-0 font-weight-normal">Free</h4>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title pricing-card-title">Ksh.1000 <small class="text-muted">/ mo</small></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                            <li>10 users included</li>
                                            <li>2 GB of storage</li>
                                            <li>Email support</li>
                                            <li>Help center access</li>
                                            </ul>
                                            <button type="button" class="btn btn-lg btn-block btn-outline-primary">Selected Option</button>
                                        </div>
                                        </div>
                                        <div class="card mb-4 box-shadow">
                                        <div class="card-header">
                                            <h4 class="my-0 font-weight-normal">Pro</h4>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title pricing-card-title">Ksh.3000 <small class="text-muted">/ mo</small></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                            <li>20 users included</li>
                                            <li>10 GB of storage</li>
                                            <li>Priority email support</li>
                                            <li>Help center access</li>
                                            </ul>
                                            <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Choose Option</button>
                                        </div>
                                        </div>
                                        <div class="card mb-4 box-shadow">
                                        <div class="card-header">
                                            <h4 class="my-0 font-weight-normal">Enterprise</h4>
                                        </div>
                                        <div class="card-body">
                                            <h1 class="card-title pricing-card-title">Ksh.5000 <small class="text-muted">/ mo</small></h1>
                                            <ul class="list-unstyled mt-3 mb-4">
                                            <li>30 users included</li>
                                            <li>15 GB of storage</li>
                                            <li>Phone and email support</li>
                                            <li>Help center access</li>
                                            </ul>
                                            <button type="button" class="btn btn-lg btn-block btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Choose Option</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>  
                                <!--payment options-->
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Payment Options</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <article class="card">
                                                <div class="card-body p-5">
                                                    <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active show" data-toggle="pill" href="#nav-tab-card">
                                                            <i class="fa fa-credit-card"></i> Debit/Credit Card</a></li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="pill" href="#nav-tab-bank">
                                                            <i class="fa fa-university"></i>  Mobile Money</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade active show" id="nav-tab-card">
                                                            <p class="alert alert-success">Some text success or error</p>
                                                            <form role="form">
                                                                <div class="form-group">
                                                                    <label for="username">Full name (on the card)</label>
                                                                    <input type="text" class="form-control" name="username" placeholder="" required="">
                                                                </div> <!-- form-group.// -->

                                                                <div class="form-group">
                                                                    <label for="cardNumber">Card number</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" name="cardNumber" placeholder="">
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
                                                                                <input type="number" class="form-control" placeholder="MM" name="">
                                                                                <input type="number" class="form-control" placeholder="YY" name="">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <div class="form-group">
                                                                            <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                                                            <input type="number" class="form-control" required="">
                                                                        </div> <!-- form-group.// -->
                                                                    </div>
                                                                </div> <!-- row.// -->
                                                                <button class="subscribe btn btn-primary btn-block" type="button"> Confirm  </button>
                                                            </form>
                                                        </div> <!-- tab-pane.// -->
                                                        <div class="tab-pane fade" id="nav-tab-bank">
                                                            <p>Mobile Money Details</p>
                                                            <dl class="param">
                                                                <dt>Paybill Number: </dt>
                                                                <dd> 800500</dd>
                                                            </dl>
                                                            <dl class="param">
                                                                <dt>Account number: </dt>
                                                                <dd> BGS</dd>
                                                            </dl>
                                                            <p><strong>Note:</strong>Additional transaction costs will be charged</p>
                                                            <button class="subscribe btn btn-primary btn-block" type="button">Pay Now</button>
                                                        </div> <!-- tab-pane.// -->
                                                    </div> <!-- tab-content .// -->
                                                </div> <!-- card-body.// -->
                                            </article>
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