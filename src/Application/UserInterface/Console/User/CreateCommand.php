<?php

namespace App\UserInterface\Console\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\User\CreateService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class CreateCommand extends Command
{
    private CreateService $createService;

    public function __construct(CreateService $createService)
    {
        parent::__construct('user:create');
        $this->createService = $createService;
    }

    public function configure()
    {
        $this->setDescription('Create new user in database');

        $this->addArgument("email", InputArgument::REQUIRED);
        $this->addArgument("password", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $email = new Email($input->getArgument('email'));
        $plainPassword = $input->getArgument('password');

        $user = $this->createService->create(
            new UserDTO(
                new Email($email),
                $plainPassword,
                'test_first_name',
                'test_last_name'
            )
        );

        $io->success("User success register: email {$user->email()->toString()} id: {$user->getId()}");

        return Command::SUCCESS;
    }
}
