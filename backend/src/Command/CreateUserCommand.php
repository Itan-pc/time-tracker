<?php

namespace App\Command;

use App\DTO\UserDTO;
use App\Factory\UserFactoryInterface;
use App\Service\UserManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

	/**
	 * @var UserManagerInterface
	 */
    private $userManager;

	/**
	 * @var ParameterBagInterface
	 */
    private $params;

	/**
	 * @var UserFactoryInterface
	 */
    private $userFactory;

	/**
	 * CreateUserCommand constructor.
	 *
	 * @param UserManagerInterface $userManager
	 * @param ParameterBagInterface $params
	 * @param UserFactoryInterface $userFactory
	 * @param string|null $name
	 */
    public function __construct(
    	UserManagerInterface $userManager,
		ParameterBagInterface $params,
		UserFactoryInterface $userFactory,
		string $name = null
	)
	{
		$this->userManager = $userManager;
		$this->params = $params;
		$this->userFactory = $userFactory;

		parent::__construct($name);
	}

	protected function configure()
    {
        $this
            ->setDescription('Create a new user')
			->setHelp('This command allows you to create a user...')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'The user email')
            ->addOption('password', null, InputOption::VALUE_REQUIRED, 'The user password (min 8 characters)')
            ->addOption('roles', null, InputOption::VALUE_REQUIRED, 'The user roles')
        ;
    }

    protected function interact(InputInterface $input, OutputInterface $output) : void
    {
        $io = new SymfonyStyle($input, $output);

		$email = $io->ask(
			$this->getDefinition()->getOption('email')->getDescription(),
			'admin@mail.com',
			function ($value) {
				Validator::validateEmailAddress($value);

				return $value;
			}
		);

		$input->setOption('email', $email);

		$password = $io->ask(
			$this->getDefinition()->getOption('password')->getDescription(),
			'12345678',
			function ($value) {
				Validator::validatePassword($value);

				return $value;
			}
		);

		$input->setOption('password', $password);

		$roleKeys = array_keys($this->params->get('security.role_hierarchy.roles'));
		$roles = array_combine($roleKeys, $roleKeys);

		$role = $io->choice(
			$this->getDefinition()->getOption('roles')->getDescription(),
			array_keys($roles),
			key($roles)
		);

		$input->setOption('roles', $roles[$role]);
    }

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);

		$data = new UserDTO(
			$input->getOption('email'),
			$input->getOption('password'),
			(array) $input->getOption('roles')
		);
		$user = $this->userFactory->create($data);

		$this->userManager->createUser($user);

		$io->success('User has created');

		return Command::SUCCESS;
	}
}
