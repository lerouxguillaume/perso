<?php

namespace App\Entity\Documents;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Movie
 * @ORM\Entity()
 * @ORM\Table(name="document_movie")
 */
class Movie extends Video
{
}