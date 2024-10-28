<?php

namespace PrestaC\App;

use PDO;
use PDOException;

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
		$dbConnection = new PDO("sqlsrv:Server=$this->host;Database=$this->name", $this->username, $this->password);
		$dbConnection->exec("set names utf8");
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return  $dbConnection;
	}
}
