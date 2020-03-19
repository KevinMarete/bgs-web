<div class="sb-page-header pb-10 sb-page-header-dark bg-gradient-primary-to-secondary">
    <div class="container-fluid">
        <div class="sb-page-header-content py-5">
            <h1 class="sb-page-header-title">
                <div class="sb-page-header-icon"><i data-feather="activity"></i></div>
                <span>Cart</span>
            </h1>
        </div>
    </div>
</div>
<div class="container-fluid mt-n10">
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <div class="container">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:60%">Product</th>
                            <th style="width:10%">Price</th>
                            <th style="width:10%">Quantity</th>
                            <th style="width:15%" class="text-center">Subtotal</th>
                            <th style="width:5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-th="Product">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4 class="nomargin">Product 1</h4>
                                        <p>Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet.</p>
                                    </div>
                                </div>
                            </td>
                            <td data-th="Price">$150.00</td>
                            <td data-th="Quantity">
                                <input type="number" class="form-control text-center" value="1">
                            </td>
                            <td data-th="Subtotal" class="text-center">150.00</td>
                            <td class="actions" data-th="">
                                <button class="btn btn-danger btn-sm"><i data-feather="trash"></i></button>								
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a href="/ordernow" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                            <td colspan="2" class="hidden-xs"></td>
                            <td class="hidden-xs text-center"><strong>Total $150.00</strong></td>
                            <td><a href="/checkout" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>