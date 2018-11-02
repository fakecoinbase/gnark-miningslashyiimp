<?php
 function doZebitexCancelOrder($OrderID=false)
{
	if(!$OrderID) return;
 	// todo
}
 function doZebitexTrading($quick=false)
{
	$exchange = 'zebitex';
	$updatebalances = true;
 	if (exchange_get($exchange, 'disabled')) return;
 	$data = zebitex_api_user('funds');
	if (empty($data)) return;
 	$savebalance = getdbosql('db_balances', "name='$exchange'");
 	foreach($data as $balance)
	{
		if ($balance->code == 'BTC') {
			if (is_object($savebalance)) {
				$savebalance->balance = $balance->balance;
				$savebalance->onsell = $balance->lockedBalance;
				$savebalance->save();
			}
			continue;
		}
 		if ($updatebalances) {
			// store available balance in market table
			$coins = getdbolist('db_coins', "symbol=:symbol OR symbol2=:symbol",
				array(':symbol'=>$balance->code)
			);
			if (empty($coins)) continue;
			foreach ($coins as $coin) {
				$market = getdbosql('db_markets', "coinid=:coinid AND name='$exchange'", array(':coinid'=>$coin->id));
				if (!$market) continue;
				$market->balance = $balance->balance;
				$market->ontrade = $balance->lockedBalance;
				$market->balancetime = time();
        $market->deposit_address = $balance->paymentAddress;
				$market->save();
			}
		}
	}
 	if (!YAAMP_ALLOW_EXCHANGE) return;
 	// real trading, todo..
}
