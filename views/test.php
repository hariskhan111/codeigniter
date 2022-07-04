<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
		color: #97310e;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		margin: 0 0 10px;
		padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>

	<div id="body">
		<h1> Count of all active and verified users: <?php echo $data['activeAndVerifiedUser']?> </h1>
		<h1> Count of active and verified users who have attached active products: <?php echo $data['activeAndVerifiedUserAndActiveproduct']?> </h1>
		<h1> Count of all active products (just from products table) <?php echo $data['activeProducts']?> </h1>
		<h1> Count of active products which don't belong to any user: <?php echo $data['activeProductDoesNothaveUser']?> </h1>
		<h1> Amount of all active attached products: <?php echo $data['amountOfActiveAttachedProduct']?> </h1>
		<h1> Summarized price of all active attached products: <?php echo $data['sum_active_attach_product']?> </h1>
		<h1> 
			Summarized prices of all active products per user
			<table>
			<?php 
				foreach($data['sum_active_attach_product_per_user'] as $user):
			?>
				
					<tr>
						<td> <?php echo $user->name ?></td>
						<td> <?php echo $user->quantity * $user->price ?> </td>
					</tr>
				
			<?php
				endforeach
			?>
			</table>
		</h1>
		<h1> Please wait for currency rate:</h1>
		<h1 id="rate"></h1>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>
<script type="text/javascript">
	var myHeaders = new Headers();
	myHeaders.append("apikey", "8RgZZOhuIHXa96ugeB9cnlRxTWATZeNr");

	var requestOptions = {
	method: 'GET',
	redirect: 'follow',
	headers: myHeaders
	};

	const currencies = ['usd','ron']
	currencies.forEach(currencyConversion)

	function currencyConversion(currency, index){
		fetch("https://api.apilayer.com/exchangerates_data/convert?to="+currency+"&from=eur&amount=1", requestOptions)
			.then(response => response.text())
			.then((response) => {
				data = JSON.parse(response)

				var str = "from " + data['query']['from'] + " to " + data['query']['to'] + " is " + data['info']['rate'] + "\n"
				document.getElementById("rate").innerText += str;
			})
			.catch(error => console.log('error', error));
	}
	
</script>
</body>
</html>
