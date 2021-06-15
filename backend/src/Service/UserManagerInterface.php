<?php


namespace App\Service;


use Symfony\Component\Security\Core\User\UserInterface;

interface UserManagerInterface
{
	/**
	 * Create User
	 *
	 * @param UserInterface $user
	 * @return UserInterface
	 */
	public function createUser(UserInterface $user) : UserInterface;

    /**
     * Create user tokens
     *
     * @param UserInterface $user
     * @return array
     */
    public function createUserTokens(UserInterface $user): array;
}