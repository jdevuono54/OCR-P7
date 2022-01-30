<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final class AddOwnerToUserSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['attachOwner', EventPriorities::PRE_WRITE],
        ];
    }

    public function attachOwner(ViewEvent $event): void
    {
        $user = $event->getControllerResult();

        if (!$user instanceof User || Request::METHOD_POST !== $event->getRequest()->getMethod()) {
            return;
        }

        $owner = $this->security->getUser();

        if (!$owner instanceof Customer) {
            return;
        }

        $user->setCustomer($owner);
    }
}