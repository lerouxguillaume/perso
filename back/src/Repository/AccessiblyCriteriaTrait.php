<?php


namespace App\Repository;


use App\Entity\Security\User;
use Doctrine\Common\Collections\Criteria;

trait AccessiblyCriteriaTrait
{
    function accessibilityCriteria(User $user = null)
    {
        $criteria = Criteria::create();
        $criteria
            ->where($criteria->expr()->eq('visibility',true))
        ;

        if (!empty($user)) {
            $criteria->orWhere($criteria->expr()->andX(
                $criteria->expr()->eq('visibility',false),
                $criteria->expr()->eq('owner', $user))
            );
        }
        return $criteria;
    }
}