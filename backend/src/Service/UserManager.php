<?php


namespace App\Service;


use App\Repository\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager implements UserManagerInterface
{
	/**
	 * @var UserRepositoryInterface
	 */
	private $userRepository;

    /**
     * @var UserPasswordEncoderInterface
     */
	private $userPasswordEncoder;

    /**
     * @var AuthenticationSuccessHandler
     */
	private $authenticationSuccessHandler;

    /**
     * UserManager constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param AuthenticationSuccessHandler $authenticationSuccessHandler
     */
	public function __construct(
	    UserRepositoryInterface $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        AuthenticationSuccessHandler $authenticationSuccessHandler
    )
	{
		$this->userRepository = $userRepository;
		$this->userPasswordEncoder = $userPasswordEncoder;
		$this->authenticationSuccessHandler = $authenticationSuccessHandler;
	}

	/**
	 * Create user
	 *
	 * @param UserInterface $user
	 * @return UserInterface
	 */
	public function createUser(UserInterface $user): UserInterface
	{
        $user->setPassword($this->userPasswordEncoder->encodePassword(
            $user,
            $user->getPassword()
        ));

		return $this->userRepository->store($user);
	}

    /**
     * Create user tokens
     *
     * @param UserInterface $user
     * @return array
     */
    public function createUserTokens(UserInterface $user): array
    {
        $tokenResponse = $this->authenticationSuccessHandler->handleAuthenticationSuccess($user);

        return json_decode($tokenResponse->getContent(), true);
    }
}