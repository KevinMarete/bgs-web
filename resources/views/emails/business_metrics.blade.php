<html>

<head></head>

<body style="font-family: monospace;">
	<main>
		<div>
			Dear Admin,
			<br />
			<br />
			The status of the business on {{ $metric->date }} was as follows: <br /><br />
		</div>
		<table style="width: 100%;font-size: smaller;border: 1px solid #c0c0c0;" cellspacing="0">
			<tbody>
				<tr style="border-bottom: : 1px solid #c0c0c0;">
					<td style="color: #092d50;"><strong>Metric</strong></td>
					<td style="color: #092d50;"><strong>Value</strong></td>
				</tr>
				<tr>
					<td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
						<strong>
							<span style="color: #7c7c7c;">New Buyers</span>
						</strong>
					</td>
					<td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
						<strong>
							<span style="color: #7c7c7c;">{{ number_format($metric->buyers) }}</span>
						</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
						<strong>
							<span style="color: #7c7c7c;">Orders Serviced</span>
						</strong>
					</td>
					<td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
						<strong>
							<span style="color: #7c7c7c;">{{ number_format($metric->orders) }}</span>
						</strong>
					</td>
				</tr>
				<tr>
					<td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
						<strong>
							<span style="color: #7c7c7c;">Revenue Collected</span>
						</strong>
					</td>
					<td style="text-align: left; border: 1px dotted #ccbcbc;" colspan="1" bgcolor="#ffffff" height="20">
						<strong>
							<span style="color: #7c7c7c;">Kshs.{{ number_format($metric->revenue) }}</span>
						</strong>
					</td>
				</tr>
			</tbody>
		</table>
	</main>
</body>

</html>