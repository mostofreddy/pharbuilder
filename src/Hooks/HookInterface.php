<?php
/**
 * HookInterface.php
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

use Symfony\Component\Console\Event\ConsoleEvent;

/**
 * HookInterface
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
interface HookInterface
{
    /**
     * Fire event
     * 
     * @return void
     */
    public function __invoke(ConsoleEvent $event);
}
