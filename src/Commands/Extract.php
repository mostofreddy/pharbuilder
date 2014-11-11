<?php
/**
 * Extract.php
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

namespace Mostofreddy\Phox\Commands;

use Mostofreddy\Phar\Stub;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Extract
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
class Extract extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('extract')
            ->setDescription('Extract a Phar package')
            ->setOptions();
    }

    protected function setOptions()
    {
        $this->addOption(
            'output',
            null,
            InputOption::VALUE_REQUIRED,
            '[REQUIRED] Output directory to extract the files.'
        )->addOption(
            'phar',
            null,
            InputOption::VALUE_REQUIRED,
            '[REQUIRED] Path to Phar file.'
        );
    }
    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int     null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('');
        $output->writeln('<comment>Extracting package</comment>');
        $this->validate($input, $output);

        $extractIn = $input->getOption('output');
        $rutaPhar = $input->getOption('phar');

        // $dir = Phar::running(false);
        $p = new \Phar($rutaPhar);
        $p->extractTo($extractIn, null, true);

        $output->writeln('');
        $output->writeln("<info>Phar extracted in </info>".$extractIn);
    }

    /**
     * Valida que los parametros obligatorios se hayan enviado
     *
     * @param InputInterface  $input  input
     * @param OutputInterface $output output
     *
     * @return void
     */
    public function validate(InputInterface $input, OutputInterface $output)
    {
        $dir = $input->getOption('output');
        if (null === $dir) {
            $output->writeln('<error>The parameter \'output\' is required</error>');
            exit(1);
        }
        if (null !== $dir) {
            if (!is_dir($dir) || !is_writable($dir)) {
                $output->writeln('<error>The directory '.$dir.' is not writable</error>');
                exit(1);
            }
        }
        $phar = $input->getOption('phar');
        if (null === $phar) {
            $output->writeln('<error>The parameter \'phar\' is required</error>');
            exit(1);
        }
        if (null !== $phar) {
            if (!is_readable($phar)) {
                $output->writeln('<error>The Phar '.$phar.' is not redeable</error>');
                exit(1);
            }
        }
    }
}
