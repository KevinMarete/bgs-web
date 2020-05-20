<html>
<head></head>
<body style="font-family: monospace;">
  <main>
    <div>
      Dear {{ $order->courier->contact }},
      <br />
      <br />
      See below are details of the order {{ '#'.$order->id }}, that we require transported.
    </div>
    <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
      <tbody>
        <tr style="border-bottom: : 1px solid #c0c0c0;">
          <td style="color: #092d50;"><strong>ProductName</strong></td>
          <td style="color: #092d50;"><strong>Quantity</strong></td>
        </tr>
        @foreach ($order->orderitems as $orderitem)
        <tr>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ $orderitem->product_now->product->molecular_name  }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ number_format($orderitem->quantity) }}</span>
            </strong>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <br/><br/>
    <div>
        See here the logistic information<br/>
        <b><u>From:</u> {{ $order->seller->name }}</b>
        <b><u>Pickup:</u> {{ $order->seller->building }}, {{ $order->seller->road}}, {{ $order->seller->town }}</b><br/>
        <b><u>To:</u> {{ $order->buyer->name }}</b>
        <b><u>Drop-off:</u> {{ $order->buyer->building }}, {{ $order->buyer->road}}, {{ $order->buyer->town }}</b>
    </div>
    <br/><br/>
    <b>N/B: The goods are ready for pick-up</b>
  </main>
</body>
</html>