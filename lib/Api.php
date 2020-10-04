<?php

namespace LaRouxOf;

use PDO;

class Api implements iOutput
{
	private ?string $response = null;
	private ?PDO $connection = null;
	private ?array $path = null;
	private ?string $call = null;

	function __construct(PDO $connection, string $call, array $path)
	{
		$this->connection = $connection;
		$this->path = $path;
		$this->call = $call;
	}

	public static function loadClass(PDO $connection, string $call)
	{
		// Split the URI into seperate path items and check that the call is really an API call.
		if(($path = Functions::splitCall($call)) == null) throw new InternalException(0, "wrong formatted request URI");
		return new self($connection, $call, $path);
	}

	public function render(): void
	{
		try {
			// Execute the real API call.
			$response = Functions::executeApiCall($this->connection, $this->path);

			// If the call returns an object, make sure it is serializable.
			if(is_object($response) && !($response instanceof JsonSerializable)) throw new InternalException(0, "object does not implement `JsonSerializable`");

			// Combine the response with status fields and actually serialize the whole respons.
			$this->response = json_encode(array('call' => $this->call, 'status' => 1, 'response' => $response));
		}
		catch(InternalException $e)
		{
			// Somewhere along the line an exception happened, construct a fail status and serialize.
			$this->response = json_encode(array('call' => $this->call, 'status' => 0, 'error' => $e->getMessage()));
		}
    }

	final public function output(): void
	{
		echo $this->response;
	}
}
?>