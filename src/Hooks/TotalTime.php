<?php
/**
 * TotalTime.php
 *
 * PHP version 5.3+
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed 
 * with this source code.
 *
 * @category  Phox
 * @package   Phox/Hooks
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */

namespace Mostofreddy\Phox\Hooks;

use Mostofreddy\Phox\Hooks\HookInterface;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\ConsoleEvents;

/**
 * TotalTime
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed 
 * with this source code.
 *
 * @category  Phox
 * @package   Phox/Hooks
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class TotalTime implements HookInterface
{
    protected $startTime = 0;

    public function __construct($start)
    {
        $this->startTime = $start;
    }
    /**
     * Fire event
     * 
     * @return void
     */
    public function __invoke(ConsoleEvent $event)
    {
        $output = $event->getOutput();
        $output->writeln('');
        $output->writeln("Time: ".round(microtime(true) - $this->startTime, 6)." seg");
        $output->writeln('');
    }
}
