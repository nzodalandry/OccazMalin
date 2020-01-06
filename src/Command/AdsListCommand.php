<?php

namespace App\Command;

use App\Repository\AdsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class AdsListCommand extends Command
{
    const VALID_FORMATS = ["json","csv"];
    const CSV_SEPARATOR = ";";

    protected static $defaultName = 'ads:list';
    private $ads;
    private $fs;
    private $kernel;

    public function __construct(AdsRepository $adsRepository, Filesystem $fs, KernelInterface $appKernel)
    {
        parent::__construct();
        $this->ads = $adsRepository;
        $this->fs = $fs;
        $this->kernel = $appKernel;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('Create the Ads list')
            ->addArgument('format', InputArgument::REQUIRED, 'Format of file can be json or csv')
            ->addOption('id', null, InputOption::VALUE_NONE, 'Add the ID column')
            ->addOption('description', null, InputOption::VALUE_NONE, 'Add the Description column')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $format = $input->getArgument('format');

        // Check the format
        if (!in_array($format, self::VALID_FORMATS))
        {
            $io->error("Not valid format. Expected : ".implode(", ", self::VALID_FORMATS));
            return 0;
        }

        // Compile Columns option
        $ads = $this->ads->findAll();

        $file = [];

        foreach ($ads as $ad)
        {
            $cols = [];

            // Column id
            if ($input->getOption('id')) 
            {
                $cols['id'] = $ad->getId();
            }

            // Column title
            $cols['title'] = $ad->getTitle();

            // Column description
            if ($input->getOption('description')) 
            {
                $cols['description'] = $ad->getDescription();
            }

            array_push($file, $cols);
        }


        // Compile file format
        switch ($format)
        {
            case 'json':
                $text = json_encode($file);
                break;

            case 'csv':
                $csv_header = [];
                
                // Column id
                if ($input->getOption('id')) 
                {
                    $csv_header[] = "id";
                }

                // Column title
                $csv_header[] = "title";

                // Column description
                if ($input->getOption('description')) 
                {
                    $csv_header[] = "description";
                }

                // Compilate the CSV text
                $text = implode(self::CSV_SEPARATOR, $csv_header)."\n";

                foreach ($file as $row)
                {
                    $text.= implode(self::CSV_SEPARATOR, $row)."\n";
                }

                break;
        }

        // Create file
        $this->fs->dumpFile(
            $this->kernel->getProjectDir()."/public/data/ads.".$format, 
            $text
        );

        // Console output
        $io->text( $text );

        return 0;
    }
}
