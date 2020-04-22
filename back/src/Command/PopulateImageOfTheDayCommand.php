<?php

namespace App\Command;

use App\Service\FetchApiNasa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PopulateImageOfTheDayCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'nasa:populate';

    /** @var FetchApiNasa */
    private $nasaService;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(FetchApiNasa $nasaService, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->nasaService = $nasaService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Create video entry.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command generate statistics for a given day, by default today')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $today = new \DateTime();
        $cpt = 0;
        while ($cpt < 50) {
            $cpt++;
            try {
                $imageOfTheDay = $this->nasaService->getImageOfTheDay($today);
                $output->writeln($imageOfTheDay->getDate()->format('d/m/Y'));
                $today->sub(new \DateInterval('P1D'));
            } catch (\OverflowException $e) {
                break;
            }
        }
        $this->nasaService->getImageOfTheDay($today);
        $output->writeln('OK :)');
        return 0;
    }
}