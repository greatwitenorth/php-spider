<?php
namespace VDB\Spider\EventListener;

use Symfony\Component\EventDispatcher\GenericEvent;
use VDB\Spider\Exception\QueueException;

/**
 * @author Matthijs van den Bos <matthijs@vandenbos.org>
 * @copyright 2013 Matthijs van den Bos
 */
class TimeLimitListener
{
    /** @var int */
    private $timeLimit;

    /**
     * @param int $timeLimit The amount of time in seconds we'll let the crawler run. Defaults to 600 seconds.
     */
    public function __construct($timeLimit = 600)
    {
        $this->timeLimit = $timeLimit;
    }

    /**
     * @param GenericEvent $event
     */
    public function onCrawlPreRequest(GenericEvent $event)
    {
        $limit = $event->getSubject('uri')->getStartTime() + $this->timeLimit;

        if ($limit < time()) {
            throw new QueueException();
        }
    }
}
