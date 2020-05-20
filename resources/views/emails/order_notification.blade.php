<html>
<head></head>
<body style="font-family: monospace;">
  <main>
    <div>
      Dear {{ $order->user->firstname }},
      <br />
      <br />
      The below are details of your order {{ '#'.$order->id }}.
    </div>
    <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
      <tbody>
        <tr style="border-bottom: : 1px solid #c0c0c0;">
          <td style="color: #092d50;"><strong>ProductName</strong></td>
          <td style="color: #092d50;"><strong>Quantity</strong></td>
          <td style="color: #092d50;"><strong>UnitPrice</strong></td>
          <td style="color: #092d50;"><strong>ItemTotal</strong></td>
        </tr>
        @foreach ($order->orderitems as $orderitem)
        <tr>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ $orderitem->product_name }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ number_format($orderitem->quantity) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ number_format($orderitem->unit_price) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2">
            <strong>
              <span style="color: #7c7c7c;">{{ number_format($orderitem->sub_total) }}</span>
            </strong>
          </td>
        </tr>
        @endforeach
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #092d50;">Sub-Total:</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2">
            <strong>
              <span style="color: #092d50;">{{ number_format($order->product_total) }}</span>
            </strong>
          </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #092d50;">Shipping-Total:</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2">
            <strong>
              <span style="color: #092d50;">{{ number_format($order->shipping_total) }}</span>
            </strong>
          </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #092d50;">Total:</span>
            </strong>
          </td>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2">
            <strong>
              <span style="color: #092d50;text-decoration: underline double;">{{ number_format($order->product_total + $order->shipping_total) }}</span>
            </strong>
          </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #092d50;">Payment Method:</span>
            </strong>
          </td>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2">
            <strong>
              <span style="color: #092d50;">{{ strtoupper($order->payment_type) }}</span>
            </strong>
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</body>
</html>