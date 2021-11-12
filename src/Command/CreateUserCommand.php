<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $em;

    private $passwordEncoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $output->writeln('Email: '.$email);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setName($email);
        $user->setPhone('');
        $user->setAddress('');
        $user->setRoles(['ROLE_ADMIN']);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln('User successfully generated!');
    }
}