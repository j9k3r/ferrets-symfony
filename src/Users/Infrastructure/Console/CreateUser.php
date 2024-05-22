<?php

namespace App\Users\Infrastructure\Console;

use App\Users\Domain\Factory\UserFactory;
use App\Users\Infrastructure\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Webmozart\Assert\Assert;

#[AsCommand(
    name: 'app:users:create-user',
    description: 'create user'
)]
class CreateUser extends Command
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserFactory $userFactory,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $io->ask('email', null, function (?string $input) {
            Assert::email($input, 'Email is invalid');

            return $input;
        });

        $password = $io->ask('password', null, function (?string $input){
            Assert::notEmpty($input, 'Password cannot be empty');

            return $input;
        });

        $roles = [
            'ROLE_DEPUTY_DIRECTOR',
            'ROLE_DIRECTOR',
            'ROLE_MODERATOR',
            'ROLE_ADMIN'
        ];

        $selectedRoles = $io->choice('Select roles', $roles, null, true);

        $user = $this->userFactory->create($email, $password, $selectedRoles);
        $this->userRepository->update($user);

        return Command::SUCCESS;
    }

}