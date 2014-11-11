<?php
/**
 * SignatureValidate.php
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
 * SignatureValidate
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
class SignatureValidate extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('sign-validate')
            ->setDescription('Validates the signature of a Phar file')
            ->setOptions();
    }
    protected function setOptions()
    {
        $this->addOption(
            'phar',
            null,
            InputOption::VALUE_REQUIRED,
            '[REQUIRED] Path to Phar.'
        )->addOption(
            'hash-string',
            null,
            InputOption::VALUE_REQUIRED,
            'Hash string created when the Phar file was signed.'
        )->addOption(
            'hash-file',
            null,
            InputOption::VALUE_REQUIRED,
            'Path to the hash file created when the Phar was signed.'
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
        $output->writeln('<comment>Validating signature</comment>');
        $this->validate($input, $output);

        $rutaPhar = $input->getOption('phar');
        $sign = $input->getOption('hash-string');
        $signFile = $input->getOption('hash-file');

        if (null !== $signFile) {
            $sign = file_get_contents($signFile);
        }

        $phar = new \Phar($rutaPhar);

        $sig = $phar->getSignature();

        if ($sig['hash'] === $sign) {
            $output->writeln('<info>Sign validated!</info>');
            return 0;
        } else {
            $output->writeln('<error>Invalid sign</error>');
            return 1;
        }
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
        $phar = $input->getOption('phar');
        if (null === $phar) {
            $output->writeln('<error>The parameter \'phar\' is required</error>');
            exit(1);
        }
        if (null !== $phar) {
            if (!is_readable($phar)) {
                $output->writeln('<error>The phar '.$phar.' is not redeable</error>');
                exit(1);
            }
        }

        $signFile = $input->getOption('hash-file');
        if (null !== $signFile) {
            if (!is_file($signFile) || !is_readable($signFile)) {
                $output->writeln('<error>The file '.$signFile.' is not redeable</error>');
                exit(1);
            }
        }

    }
}
