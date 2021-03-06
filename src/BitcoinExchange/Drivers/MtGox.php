<?php namespace BitcoinExchange\Drivers;

class MtGox extends \MtGox\MtGox
{

	public function ticker(){
		$ticker = new Arr($this->getTicker());
		$new_ticker = new Arr([
		  "high"=> $ticker->high->value,
		  "last"=> $ticker->last->value,
		  "timestamp"=> time(),
		  "bid"=> $ticker->buy->value,
		  "volume"=> $ticker->vol->value,
		  "low"=> $ticker->low->value,
		  "ask"=> $ticker->sell->value
		]);
		
		return $new_ticker;
	}

	public function buy(){
		$params = func_get_args();
		array_unshift($params, "buy");
		return new Arr(call_user_func_array([$this, "placeOrder"], $params));
	}

	public function sell(){
		$params = func_get_args();
		array_unshift($params, "sell");
		return new Arr(call_user_func_array([$this, "placeOrder"], $params));	}

	public function cancel(){
		return new Arr(call_user_func_array([$this, "cancelOrder"], func_get_args()));
	}

	public function balance(){
		$info = parent::getInfo();
		return new Arr($info['Wallets']);
	}

}