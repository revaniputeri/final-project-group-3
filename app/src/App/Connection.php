<?php

namespace PrestaC\App;

use PDO;

class Connection
{
	private ?PDO $connection = null;

	public function __construct(
		private string $host,
		private string $name,
		private string $username,
		private string $password,
	) {}

	public function getConnection()
	{
		if ($this->connection === null) {
			$this->connection = $this->connect();
		}
		return $this->connection;
	}

	private function connect()
	{
		$dbConnection = new PDO("sqlsrv:server=$this->host;Database=$this->name", $this->username, $this->password);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return  $dbConnection;
	}
}
