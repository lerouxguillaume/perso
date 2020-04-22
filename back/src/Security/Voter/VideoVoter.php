<?php

namespace App\Security\Voter;

use App\Entity\Documents\Episode;
use App\Entity\Documents\Movie;
use App\Entity\Documents\Video;
use App\Entity\Security\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class VideoVoter extends Voter
{
    const VIEW = 'view';

    /** @var EntityManagerInterface */
    private $em;

    /**
     * VideoVoter constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Video) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if ($user !== 'anon.' && !$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Video $post */
        $video = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($video, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Video $video, $user): bool
    {
        $movieRepository = $this->em->getRepository(Movie::class);
        $episodeRepository = $this->em->getRepository(Episode::class);
        /** @var Movie $movie */
        if ($movie = $movieRepository->findOneBy(['video' => $video])) {
            return $movie->getVisibility() || $movie->getOwner() === $user;
        }
        /** @var Episode $episode */
        if ($episode = $episodeRepository->findOneBy(['video' => $video])) {
            $serie = $episode->getSerie();
            return $serie->getVisibility() || $serie->getOwner() === $user;
        }

        return false;
    }
}