<?php

namespace PrestaC\App;

use PDO;

class Connection
{
	//property connectionnya
	private ?PDO $connection = null;

	//constructor buat nyimpen credentialnya
	public function __construct(
		private string $host,
		private string $name,
		private string $username,
		private string $password,
	) {}

	//method buat ngecek apakah connectionnya sudah ada atau belum, kalo belum ada, buat connection baru
	public function getConnection()
	{
		if ($this->connection === null) {
			$this->connection = $this->connect();
		}
		return $this->connection;
	}

	//method buat ngebuat connection baru
	private function connect()
	{
		$dbConnection = new PDO("sqlsrv:server=$this->host;Database=$this->name", $this->username, $this->password);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return  $dbConnection;
	}
}
