<html>
<head>
</head>
<body  style="font-family: monospace;">
  <main>
    <div>
      Dear {{$user->firstname}},
      <br/>
      <br/>
      The below are details of your account for activation. 

    </div>

    <table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;"  cellspacing="0">
      <tbody>
        <tr style="border-bottom: : 1px solid #c0c0c0;">
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" colspan="3"  height="30">
            <span style="text-decoration: underline;">
              <strong>
                <span style="color: #092d50; font-size: x-large; text-decoration: underline;">Account activation</span>
              </strong>
            </span>
          </td>
        </tr>
        <tr>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" colspan="1"  bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">First Name.:</span>
            </strong>
          </td>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2" >
            <strong>
              <span style="color: #092d50;">{{$user->firstname}}</span>
            </strong>
          </td>
        </tr> 
        <tr>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" colspan="1"  bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Lastname:</span>
            </strong>
          </td>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2" >
            <strong>
              <span style="color: #092d50;">{{$user->lastname}}</span>
            </strong>
          </td>
        </tr> 

        <tr>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" colspan="1"  bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Phone:</span>
            </strong>
          </td>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2" >
            <strong>
              <span style="color: #092d50;">{{$user->phone}}</span>
            </strong>
          </td>
        </tr> 
        
        <tr>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" colspan="1"  bgcolor="#ffffff" height="20">
            <strong>
              <span style="color: #7c7c7c;">Activation Code:</span>
            </strong>
          </td>
          <td style="text-align: left; border-bottom: 1px dotted #ccbcbc;" bgcolor="#ffffff" colspan="2" >
            <strong>
              <span style="color: #092d50;">{{$user->code}}</span>
            </strong>
          </td>
        </tr> 
      </tbody>
    </table>

    <div>

    </div>
  </main>
</body>
</html>