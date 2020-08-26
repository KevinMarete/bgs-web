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
    @if (Session::has('bgs_msg'))
    {!! session('bgs_msg') !!}
    @endif
    <div class="card mb-4">
        <div class="card-header"> </div>
        <div class="card-body">
            <div class="container">
                <div class="table-responsive">
                    <table id="cart" class="table table-sm table-hover table-condensed table-striped table-bordered">
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
                            @foreach ($cart_items as $cart_item)
                            <tr>
                                <form role="form" action="/update-cart/{{ $cart_item['product_id'] }}" method="POST">
                                    @csrf
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h6 class="nomargin">{{ $cart_item['product_name'] }}</h6>
                                                <p>
                                                    <small>
                                                        {{ $cart_item['product_description'] }} <br />
                                                        {{ 'Organization: '.$cart_item['organization_name'] }}
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price">KES {{ number_format($cart_item['price']) }}</td>
                                    <td data-th="Quantity">
                                        <input type="text" class="form-control text-center" name="quantity" value="{{ number_format($cart_item['quantity']) }}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                    </td>
                                    <td data-th="Subtotal" class="text-center">KES {{ number_format($cart_item['sub_total']) }}</td>
                                    <td class="actions" data-th="">
                                        <input type="hidden" name="price" value="{{ $cart_item['price'] }}" />
                                        <input type="hidden" value="{{ $total += $cart_item['sub_total'] }}" />
                                        <button type="submit" class="btn btn-info btn-sm"><i data-feather="edit"></i></button>
                                        <a href="remove-cart/{{ $cart_item['product_id'] }}" class="btn btn-danger btn-sm delete"><i data-feather="trash"></i></button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><a href="/{{ $back_to_link }}" class="btn btn-sm btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a></td>
                                <td colspan="2" class="hidden-xs"></td>
                                <td class="hidden-xs text-center"><strong> KES {{ number_format($total) }} </strong></td>
                                @if (sizeof($cart_items) > 0)
                                <td>
                                    <a href="/checkout" class="btn btn-sm btn-success">Checkout <i class="fa fa-angle-right"></i></a>
                                </td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>