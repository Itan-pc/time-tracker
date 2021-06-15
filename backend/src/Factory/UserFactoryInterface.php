<?php


namespace App\Factory;


use App\DTO\UserDTO;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserFactoryInterface
{
	/**
	 * Create user instance
	 *
	 * @param UserDTO $userDTO
	 * @return UserInterface
	 */
	public function create(UserDTO $userDTO) : UserInterface;
}