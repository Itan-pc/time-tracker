<?php


namespace App\Repository;


use Symfony\Component\Security\Core\User\UserInterface;

interface UserRepositoryInterface
{
	/**
	 * Store user
	 *
	 * @param UserInterface $user
	 * @return mixed
	 */
	public function store(UserInterface $user) : UserInterface;
}