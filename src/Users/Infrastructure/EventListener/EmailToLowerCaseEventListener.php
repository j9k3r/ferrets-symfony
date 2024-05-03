<?php

namespace App\Users\Infrastructure\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;
use App\Users\Domain\Entity\User;

class EmailToLowerCaseEventListener
{
    public function prePersist(User $user, LifecycleEventArgs $args)
    {
        $user->setEmail(strtolower($user->getEmail()));
    }

//    public function preUpdate(User $user, LifecycleEventArgs $args)
//    {
//        $user->setEmail(strtolower($user->getEmail()));
//    }
}