<?php


namespace App\Exception;


use LogicException;

class JsonNotValidException extends LogicException
{
	/**
	 * @return JsonNotValidException
	 */
	public static function new(): self
	{
		return new self('Request parameters is not valid JSON.', 10);
	}
}