<?php


namespace App\Factory;


use App\DTO\UserDTO;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFactory implements UserFactoryInterface
{
	/**
	 * Password encoder
	 *
	 * @var UserPasswordEncoderInterface
	 */
	private $passwordEncoder;

	/**
	 * UserFactory constructor.
	 *
	 * @param UserPasswordEncoderInterface $passwordEncoder
	 */
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

	/**
	 * Create user instance
	 *
	 * @param UserDTO $userDTO
	 * @return UserInterface
	 */
	public function create(UserDTO $userDTO): UserInterface
	{
		$user = new User();
		$user->setEmail($userDTO->getEmail());
		$user->setRoles($userDTO->getRoles());
		$user->setPassword($this->passwordEncoder->encodePassword(
			$user,
			$userDTO->getPassword()
		));

		return $user;
	}
}