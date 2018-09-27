<?php

namespace App\EventSubscriber;

use App\Entity\Book;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class BookMailSubscriber implements EventSubscriberInterface
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $book = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();

        if (!$book instanceof Book || Request::METHOD_POST !== $method) {
            return;
        }

        $message = (new \Swift_Message('A new book has been added'))
            ->setFrom('rahrindra@gmail.com')
            ->setTo('rahrindra.fr@gmail.com')
            ->setBody(sprintf('The book #%d has been added.', $book->getId()));

        $this->mailer->send($message);
    }

    public static function getSubscribedEvents()
    {
        return [
           'kernel.view' => 'onKernelView',
        ];
    }
}
