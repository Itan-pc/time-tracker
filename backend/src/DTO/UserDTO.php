<?php


namespace App\DTO;


class UserDTO
{
	/**
	 * User ID
	 *
	 * @var int
	 */
	private $id;

	/**
	 * User email
	 *
	 * @var string
	 */
	private $email;

	/**
	 * User password
	 *
	 * @var string
	 */
	private $password;

	/**
	 * User roles
	 *
	 * @var array
	 */
	private $roles;

	/**
	 * UserDTO constructor.
	 *
	 * @param string $email
	 * @param string $password
	 * @param array $roles
	 */
	public function __construct(string $email, string $password, array $roles)
	{
		$this->email = $email;
		$this->password = $password;
		$this->roles = $roles;
	}

	/**
	 * Set id
	 *
	 * @param int $id
	 * @return UserDTO
	 */
	public function setId(int $id) : self
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get user id
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * Get user email
	 *
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * Get user password
	 *
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * Get user roles
	 *
	 * @return array
	 */
	public function getRoles(): array
	{
		return $this->roles;
	}
}