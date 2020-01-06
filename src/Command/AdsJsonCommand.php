<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AdsJsonCommand extends Command
{
    protected static $defaultName = 'app:ads-json';

    protected function configure()
    {
        // php bin/console app:ads-json <arg1>
        // php bin/console app:ads-json <arg1> [<arg2>]
        // php bin/console app:ads-json <arg1> --option1
        // php bin/console app:ads-json <arg1> --option2
        // php bin/console app:ads-json <arg1> -o2
        $this
            // Ajoute une descrition
            // php bin/console list
            ->setDescription('Add a short description for your command')

            // Definir des arguments
            // Doc : php bin/console help app:ads-json
            // - arg1 requis
            // - arg2 optionel
            ->addArgument('arg1', InputArgument::REQUIRED, 'Argument description')
            ->addArgument('arg2', InputArgument::OPTIONAL, 'Argument description')

            // Definir les options
            // - --option1
            // - --option2
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
            ->addOption('option2', '-o', InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Recupération des arguments
        $arg1 = $input->getArgument('arg1');
        $arg2 = $input->getArgument('arg2');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }
        if ($arg2) {
            $io->note(sprintf('You passed an argument: %s', $arg2));
        }

        // Différentes sorties
        // $io->text("Un text");
        // $io->note("Une Note");
        // $io->success("Un succes");
        // $io->warning("Un warning");
        // $io->error("Une erreur");

        if ($input->getOption('option1')) 
        {
            $io->success("On passe l'option 1");
        }
        if ($input->getOption('option2')) 
        {
            $io->success("On passe l'option 2");
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
