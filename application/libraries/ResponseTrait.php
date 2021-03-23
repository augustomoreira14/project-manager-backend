<?php

trait ResponseTrait
{
	protected $codes = [
		'201' => 'CREATED',
		'200' => 'OK',
		'404' => 'NOT FOUND',
		'400' => 'Test'
	];

	public function respond($data = null, $status = 200, $message = '')
	{
		header('Content-Type: application/json');
		$message = $message !== '' ? $message : $this->codes[$status];
		header("HTTP/1.1 {$status} {$message}");

		echo json_encode($data);
	}
}
