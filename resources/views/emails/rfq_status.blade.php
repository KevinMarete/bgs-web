<html>

<head></head>

<body style="font-family: monospace;">
  <main>
    <div>
      Dear {{ $rfq->to_user_description }},
      <br />
      <br />
      {{ $rfq->message }}
      <br />
      <br />
      The current status for the RFQ is <b>{{ $rfq->status }}</b> <br /><br />
      See below are details of the RFQ {{ '#'.$rfq->id }}.
    </div>
    <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
      <tbody>
        <tr style="border-bottom: : 1px solid #c0c0c0;">
          <td style="color: #092d50;"><strong>ProductName</strong></td>
          <td style="color: #092d50;"><strong>Quantity</strong></td>
          <td style="color: #092d50;"><strong>UnitPrice</strong></td>
          <td style="color: #092d50;"><strong>SubTotal</strong></td>
        </tr>
        @foreach ($rfq->rfq_items as $rfqitem)
        @if(!$rfqitem->out_of_stock)
        <tr>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ mb_strtoupper($rfqitem->product_now->product->brand_name).'-'.mb_strtoupper($rfqitem->product_now->product->molecular_name) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">{{ number_format($rfqitem->quantity) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">KES {{ number_format($rfqitem->unit_price) }}</span>
            </strong>
          </td>
          <td style="text-align: left; border: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2">
            <strong>
              <span style="color: #7c7c7c;">KES {{ number_format($rfqitem->sub_total) }}</span>
            </strong>
          </td>
        </tr>
        @endif
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
              <span style="color: #092d50;">KES {{ number_format($rfq->overall_sub_total) }}</span>
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
              <span style="color: #092d50;">KES {{ number_format($rfq->overall_shipping_total) }}</span>
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
              <span style="color: #092d50;text-decoration: underline double;">KES {{ number_format($rfq->overall_total) }}</span>
            </strong>
          </td>
        </tr>
      </tbody>
    </table>
    <br />
    @if($rfq->terms)
    Please note the terms of the quotation are as follows:<br />
    <b>{{ ucfirst($rfq->terms) }}</b>
    @endif
    <br />
    <br />
    Regards,
    <br />
    <br />
    {{ $rfq->from_user_description }}
  </main>
</body>

</html>