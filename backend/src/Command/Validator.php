<?php


namespace App\Command;


use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Bundle\MakerBundle\Validator as CommandValidator;

class Validator
{
	/**
	 * Field must be not blank
	 *
	 * @param string|null $value
	 * @return string
	 */
	public static function notBlank(string $value = null): string
	{
		return CommandValidator::notBlank($value);
	}

	/**
	 * Validate boolean
	 *
	 * @param $value
	 * @return bool|mixed
	 */
	public static function validateBoolean($value)
	{
		return CommandValidator::validateBoolean($value);
	}

	/**
	 * Validate email address
	 *
	 * @param string|null $email
	 * @return string
	 */
	public static function validateEmailAddress(?string $email): string
	{
		return CommandValidator::validateEmailAddress($email);
	}

	/**
	 * Validate password
	 *
	 * @param string $password
	 * @return string
	 */
	public static function validatePassword(string $password): string
	{
		if (strlen($password) < 8) {
			throw new RuntimeCommandException('Password must be 8 characters or more');
		}

		return $password;
	}
}