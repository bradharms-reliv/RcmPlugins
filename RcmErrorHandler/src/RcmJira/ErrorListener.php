<?php

namespace RcmJira;

use RcmErrorHandler\EventManager\HandlerListenerBase;
use RcmErrorHandler\Format\FormatBase;
use RcmJira\Exception\JiraListenerException;

/**
 * Class ErrorListener
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   RcmJira
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2014 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ErrorListener extends HandlerListenerBase
{
    /**
     * update
     *
     * @param \Zend\EventManager\Event $event
     *
     * @return void
     * @throws JiraListenerException
     */
    public function update(\Zend\EventManager\Event $event)
    {
        /** @var \RcmErrorHandler\Handler\Handler $handler */
        // $handler = $event->getParam('handler');

        /** @var \RcmErrorHandler\Model\GenericError $error */
        $error = $event->getParam('error');

        $firstError = $error->getFirst();

        /** @var \RcmErrorHandler\Model\Config $config */
        // $config = $event->getParam('config');

        $formatter = new FormatBase();

        $logger = new JiraLogger($this->options->getAll());

        $extras = array(
            'file' => $firstError->getFile(),
            'line' => $firstError->getLine(),
            'message' => $firstError->getMessage(),
            'trace' => $formatter->getTraceString($firstError)
        );

        $logger->log(
            $logger->getPriorityFromErrorNumber($firstError->getSeverity()),
            $firstError->getType() . ' - ' . $firstError->getMessage() . ' - ' . $firstError->getFile(),
            $extras
        );
    }
} 