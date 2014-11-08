<?php
/**
 * App.php
 *
 * PHP version 5.3+
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed 
 * with this source code.
 *
 * @category  Phox
 * @package   Phox
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Mostofreddy\Phox;

use Mostofreddy\Phox\Hooks\ValidateDependencies;
use Mostofreddy\Phox\Hooks\Header;
use Mostofreddy\Phox\Hooks\TotalTime;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\ConsoleEvents;

/**
 * App
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed 
 * with this source code.
 *
 * @category  Phox
 * @package   Phox
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class App extends Application
{
    protected $timeStart = 0;
    /**
     * Constructor
     * 
     * @param string $name    The name of the application
     * @param string $version The version of the application
     */
    public function __construct($name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->timeStart = microtime(true);
        parent::__construct($name, $version);
    }

    /**
     * Runs the current application.
     *
     * @param InputInterface  $input  An Input instance
     * @param OutputInterface $output An Output instance
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @throws \Exception When doRun returns Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->addHooks();
        parent::run($input, $output);
    }
    /**
     * Set all hooks
     *
     * @return  void
     */
    protected function addHooks()
    {
        $dispatcher = new EventDispatcher();

        $dispatcher->addListener(ConsoleEvents::COMMAND, new Header());
        $dispatcher->addListener(ConsoleEvents::COMMAND, new ValidateDependencies());
        $dispatcher->addListener(ConsoleEvents::TERMINATE, new TotalTime($this->timeStart));

        $this->setDispatcher($dispatcher);
    }
}
