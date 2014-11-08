<?php
/**
 * ValidateDependencies.php
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
 * ValidateDependencies
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
class ValidateDependencies implements HookInterface
{
    /**
     * Fire event
     * 
     * @return void
     */
    public function __invoke(ConsoleEvent $event)
    {
        $output = $event->getOutput();

        $output->writeln("<comment>Validating dependencies:</comment>");

        $output->write(str_pad("Phar extension is loaded?", 30, '.'));
        $error = false;
        if (!extension_loaded('phar')) {
            $output->writeln('<error>NOK</error>');
            $error = true;
        } else {
            $output->writeln('<info>OK</info>');
        }
        
        $output->write(str_pad("phar.readonly is On?", 30, '.'));
        if (!\Phar::canWrite()) {
            $output->writeln('<error>NOK</error>');
            $error = true;
        } else {
            $output->writeln('<info>OK</info>');
        }
        if ($error) {
            exit(1);
        }
    }
}
