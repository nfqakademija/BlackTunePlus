<?php

namespace AppBundle\Command;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AppDbSeedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:db:seed')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $fk = \Faker\Factory::create();

        if ($userCount = $input->getOption('option')) {
            for ($i=0; $i < $userCount; $i++) {
                $user = new User();
                $user->setFirstName($fk->name);
            }
            $em->flush();
        }

        $output->writeln('Command result.');
    }
}
