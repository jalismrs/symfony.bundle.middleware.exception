<?php
declare(strict_types = 1);

namespace Jalismrs\Symfony\Bundle\JalismrsExceptionMiddlewareBundle\EventSubscriber;

use Jalismrs\Symfony\Bundle\JalismrsExceptionMiddlewareBundle\IsApiControllerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class IsApiControllerMiddleware
 *
 * @package Jalismrs\Symfony\Bundle\JalismrsExceptionMiddlewareBundle\EventSubscriber
 */
final class ExceptionMiddleware implements
    EventSubscriberInterface
{
    /**
     * getSubscribedEvents
     *
     * @static
     * @return array|array[]
     *
     * @codeCoverageIgnore
     */
    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::EXCEPTION => [
                'onKernelException',
                0,
            ],
        ];
    }
    
    /**
     * onKernelException
     *
     * @param \Symfony\Component\HttpKernel\Event\ExceptionEvent $exceptionEvent
     *
     * @return \Symfony\Component\HttpKernel\Event\ExceptionEvent
     */
    public function onKernelException(
        ExceptionEvent $exceptionEvent
    ) : ExceptionEvent {
        return $exceptionEvent;
    }
}
