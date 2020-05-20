<html>

<head></head>

<body style="font-family: monospace;">
  <main>
    <div>
      Dear Customer,
      <br />
      <br />
      Please see below various promotions and deals from BGS available on {{ $mailing_list->date }}: <br /><br />
    </div>
    @if (sizeof($mailing_list->promos) > 0)
    <b>Available Promotions({{ sizeof($mailing_list->promos) }}) Click <a href="www.bgsmeds.com" target="_blank">Here</a> to Purchase Promotion Item(s)</b>
    <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
      <tbody>
        <tr style="border-bottom: : 1px solid #c0c0c0;">
          <td style="color: #092d50;"><strong>Product</strong></td>
          <td style="color: #092d50;"><strong>UsualPrice</strong></td>
          <td style="color: #092d50;"><strong>CouponCode</strong></td>
          <td style="color: #092d50;"><strong>DiscountPrice</strong></td>
          <td style="color: #092d50;"><strong>ValidUntil</strong></td>
          <td style="color: #092d50;"><strong>Seller</strong></td>
        </tr>
        @foreach ($mailing_list->promos as $promo)
        <tr>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ ucwords($promo['product_now']['product']['molecular_name']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Kshs.{{ number_format($promo['product_now']['unit_price']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ strtoupper($promo['coupon_code']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Kshs.{{ number_format((1- ($promo['offer']['discount']/100))*$promo['product_now']['unit_price']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ date_format(date_create($promo['offer']['valid_until']), 'Y-m-d') }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ $promo['product_now']['organization']['name'] }}</span>
            </strong>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
    <br />
    <br />
    @if (sizeof($mailing_list->deals) > 0)
    <b>Available Deals({{ sizeof($mailing_list->deals) }}) Click <a href="www.bgsmeds.com" target="_blank">Here</a> to Purchase Deal Item(s)</b>
    <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
      <tbody>
        <tr style="border-bottom: : 1px solid #c0c0c0;">
          <td style="color: #092d50;"><strong>Product</strong></td>
          <td style="color: #092d50;"><strong>UsualPrice</strong></td>
          <td style="color: #092d50;"><strong>MinimumOrderQty</strong></td>
          <td style="color: #092d50;"><strong>DiscountPrice</strong></td>
          <td style="color: #092d50;"><strong>ValidUntil</strong></td>
          <td style="color: #092d50;"><strong>Seller</strong></td>
        </tr>
        @foreach ($mailing_list->deals as $deal)
        <tr>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ ucwords($deal['product_now']['product']['molecular_name']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Kshs.{{ number_format($deal['product_now']['unit_price']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ strtoupper($deal['minimum_order_quantity']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Kshs.{{ number_format((1- ($deal['offer']['discount']/100))*$deal['product_now']['unit_price']) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ date_format(date_create($deal['offer']['valid_until']), 'Y-m-d') }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ $deal['product_now']['organization']['name'] }}</span>
            </strong>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
    <br />
    <br />
    Regards, <br />
    BGS Meds
  </main>
</body>

</html>