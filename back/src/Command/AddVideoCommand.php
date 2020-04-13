<?php

namespace App\Command;

use App\Entity\Documents\Episode;
use App\Entity\Documents\Movie;
use App\Entity\Documents\Serie;
use App\Entity\Documents\VideoFactory;
use App\Service\VideoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddVideoCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'video:add';

    /** @var VideoService */
    private $videoService;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(VideoService $videoService, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->videoService = $videoService;

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
            ->addArgument('path',  InputArgument::REQUIRED, 'Path to the file')
            ->addArgument('name',  InputArgument::REQUIRED, 'Name of the video')
            ->addArgument('videoType',  InputArgument::REQUIRED, 'Type of the video')
            ->addArgument('serie',  InputArgument::OPTIONAL, 'Id of the serie related')
            ->addArgument('episode',  InputArgument::OPTIONAL, 'Episode number (required if part of a serie')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $name = $input->getArgument('name');
        $videoType = $input->getArgument('videoType');
        $serieId = $input->getArgument('serie');
        $episode = (int) $input->getArgument('episode');
        $serie = null;
        if (!empty($serieId)) {
            if (empty($episode)) {
                $output->writeln('Episode cannot be empty if serie is defined');
                return;
            }
            if (empty($serie = $this->em->getRepository(Serie::class)->find($serieId))) {
                $output->writeln('Serie does not exist');
                return;
            }
        }

        if (!empty($episode) && !is_int($episode)) {
            $output->writeln('Episode have to be an int');
            return;
        }

        if (!is_file($path)) {
            $output->writeln('Invalid file path');
            return;
        }

        try {
            $video = $this->videoService->addVideo($path, $name);
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
            return;
        }

        $content = VideoFactory::Video($videoType);
        $content
            ->setVideo($video)
        ;
        if ($content instanceof Episode) {
            if (!empty($serie)) {
                $content
                    ->setEpisode($episode)
                    ->setSerie($serie)
                ;
            }
        } elseif ($content instanceof Movie) {
            $content->setName($name);
        }

        $this->em->persist($content);
        $this->em->flush();

        $output->writeln('OK :)');
        return 0;
    }
}