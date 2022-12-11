<html>

<head></head>

<body style="font-family: monospace;">
<main>
    <div>
        Dear Customer,
        <br/>
        <br/>
        Please see below various offers from {{ config('app.label') }} available on {{ $mailing_list->date }}:
        <br/><br/>
    </div>
    @if (sizeof($mailing_list->offers) > 0)
        <b>Available Offers({{ sizeof($mailing_list->offers) }}) Click <a href="{{ env('APP_DOMAIN') }}"
                                                                          target="_blank">Here</a> to Purchase Deal
            Item(s)</b>
        <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
            <tbody>
            <tr style="border-bottom: 1px solid #c0c0c0;">
                <td style="color: #092d50;"><strong>Product</strong></td>
                <td style="color: #092d50;"><strong>UsualPrice</strong></td>
                <td style="color: #092d50;"><strong>MinimumOrderQty</strong></td>
                <td style="color: #092d50;"><strong>DiscountPrice</strong></td>
                <td style="color: #092d50;"><strong>ValidUntil</strong></td>
                <td style="color: #092d50;"><strong>Seller</strong></td>
            </tr>
            @foreach ($mailing_list->offers as $offer)
                <tr>
                    <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
                        <strong>
                            <span
                                style="color: #7c7c7c;">{{ ucwords($offer['product_now']['product']['molecular_name']) }}</span>
                        </strong>
                    </td>
                    <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
                        <strong>
                            <span
                                style="color: #7c7c7c;">Kshs.{{ number_format($offer['product_now']['unit_price']) }}</span>
                        </strong>
                    </td>
                    <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
                        <strong>
                            <span style="color: #7c7c7c;">{{ strtoupper($offer['min_order_quantity']) }}</span>
                        </strong>
                    </td>
                    <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
                        <strong>
                            <span
                                style="color: #7c7c7c;">Kshs.{{ number_format((1- ($offer['discount']/100))*$offer['product_now']['unit_price']) }}</span>
                        </strong>
                    </td>
                    <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
                        <strong>
                            <span
                                style="color: #7c7c7c;">{{ date_format(date_create($offer['valid_until']), 'Y-m-d') }}</span>
                        </strong>
                    </td>
                    <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
                        <strong>
                            <span style="color: #7c7c7c;">{{ $offer['organization']['name'] }}</span>
                        </strong>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <br/>
    <br/>
    Regards, <br/>
    {{ config('app.label') }}
</main>
</body>

</html>
