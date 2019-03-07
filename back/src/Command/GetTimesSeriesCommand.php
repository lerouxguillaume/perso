<?php

namespace App\Command;

use App\Entity\DailyStats;
use App\Entity\Entreprise;
use App\Entity\TimeSerie;
use App\Service\FetchApiAlphaVantage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetTimesSeriesCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'trend:initiate:company';

    /** @var FetchApiAlphaVantage */
    private $apiAlphaVantage;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(FetchApiAlphaVantage $apiAlphaVantage, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->apiAlphaVantage = $apiAlphaVantage;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Generate trending series.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command generate statistics for a given day, by default today')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entreprises = $this->em->getRepository(Entreprise::class)->findAll();
        $todayTimestamp = strtotime('today midnight');
        $batchSize = 100;
        /** @var Entreprise $entreprise */
        foreach ($entreprises as $entreprise) {
            $entreprise = $this->em->getRepository(Entreprise::class)->find($entreprise->getId());
            $lastTimeSerie = $this->em->getRepository(TimeSerie::class)->findLastTimeSerieTimestamp($entreprise) ?? 0;

            $output->writeln("Traitement de : ". $entreprise->getRaisonSociale());
            $currentData = $this->apiAlphaVantage->getDailyCotes($entreprise->getCode());
            /** @var TimeSerie $currentDatum */
            foreach ($currentData as $key => $currentDatum) {
                if ($todayTimestamp !== $currentDatum->getTimestamp() && $lastTimeSerie < $currentDatum->getTimestamp()) {
                    $currentDatum->setEntreprise($entreprise);
                    $this->em->persist($currentDatum);
                    if (($key % $batchSize) === 0) {
                        $this->em->flush();
                    }
                }
            }
            $this->em->flush();
            $this->em->clear(); // Detaches all objects from Doctrine!
            sleep(20);
        }
    }
}