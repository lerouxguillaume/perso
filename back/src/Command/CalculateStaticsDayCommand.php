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

class CalculateStaticsDayCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'trend:generate-stats';

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
            ->setDescription('Generate trending statistics.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command generate statistics for a given day, by default today')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entreprises = $this->em->getRepository(Entreprise::class)->findAll();

        $todayTimestamp = strtotime('today midnight');

        $todayDate = (new \DateTime())->setTimestamp($todayTimestamp);
        $weekAgo = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 week');
        $monthAgo = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 month');
        $trimesterAgo = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-3 month');
        $yearAgo = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-1 year');
        $fiveYearAgo = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-5 year');
        $tenYearAgo = (new \DateTime())->setTimestamp($todayTimestamp)->modify('-10 year');

        $todayTimeSerie = null;
        $weekAgoTimeSerie = null;
        $monthAgoTimeSerie = null;
        $trimesterAgoTimeSerie = null;
        $yearAgoTimeSerie = null;
        $fiveYearAgoTimeSerie = null;
        $tenYearAgoTimeSerie = null;

        /** @var Entreprise $entreprise */
        foreach ($entreprises as $entreprise) {
            $output->writeln("Traitement de : ". $entreprise->getRaisonSociale());
            $currentData = $this->apiAlphaVantage->getDailyCotes($entreprise->getCode());
            /** @var TimeSerie $currentDatum */
            foreach ($currentData as $currentDatum) {
                switch ($currentDatum->getTimestamp()) {
                    case $todayTimestamp:
                        $todayTimeSerie = $currentDatum;
                        break;
                    case $weekAgo->getTimestamp():
                        $weekAgoTimeSerie = $currentDatum;
                        break;
                    case $monthAgo->getTimestamp():
                        $monthAgoTimeSerie = $currentDatum;
                        break;
                    case $trimesterAgo->getTimestamp():
                        $trimesterAgoTimeSerie = $currentDatum;
                        break;
                    case $yearAgo->getTimestamp():
                        $yearAgoTimeSerie = $currentDatum;
                        break;
                    case $fiveYearAgo->getTimestamp():
                        $fiveYearAgoTimeSerie = $currentDatum;
                        break;
                    case $tenYearAgo->getTimestamp():
                        $tenYearAgoTimeSerie = $currentDatum;
                        break;
                }
            }

            if (empty($todayTimeSerie)) {
                $output->writeln(
                    'impossible de trouver les infos du jour pour : '. $entreprise->getRaisonSociale()
                );
                continue;
            }

            $newDailyStats = $this->em->getRepository(DailyStats::class)
                    ->findOneBy(['day' => $todayDate, 'entreprise' => $entreprise]) ?? new DailyStats();
            $newDailyStats
                ->setDay($todayDate)
                ->setEntreprise($entreprise)
                ->setDayVariance(0) //@TODO
            ;
            if (!empty($weekAgoTimeSerie)) {
                $newDailyStats->setWeekVariance($this->getPercentIncrease($todayTimeSerie, $weekAgoTimeSerie));
            }
            if (!empty($monthAgoTimeSerie)) {
                $newDailyStats->setMonthVariance($this->getPercentIncrease($todayTimeSerie, $monthAgoTimeSerie));
            }
            if (!empty($trimesterAgoTimeSerie)) {
                $newDailyStats->setTrimesterVariance($this->getPercentIncrease($todayTimeSerie, $trimesterAgoTimeSerie));
            }
            if (!empty($yearAgoTimeSerie)) {
                $newDailyStats->setYearVariance($this->getPercentIncrease($todayTimeSerie, $yearAgoTimeSerie));
            }
            if (!empty($fiveYearAgoTimeSerie)) {
                $newDailyStats->setFiveYearVariance($this->getPercentIncrease($todayTimeSerie, $fiveYearAgoTimeSerie));
            }
            if (!empty($tenYearAgoTimeSerie)) {
                $newDailyStats->setTenYearVariance($this->getPercentIncrease($todayTimeSerie, $tenYearAgoTimeSerie));
            }
            $this->em->persist($newDailyStats);
            $this->em->flush();
            sleep(20);
        }
    }

    private function getPercentIncrease(TimeSerie $new, TimeSerie $old)
    {
        return $new->getClose()*100/$old->getClose()-100;
    }
}