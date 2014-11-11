<?php
/**
 * SignatureCreate.php
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
 * SignatureCreate
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
class SignatureCreate extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('sign-create')
            ->setDescription('Add signature to a Phar file')
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
            'encrypt-type',
            null,
            InputOption::VALUE_REQUIRED,
            'Encryption algorithm (MD5, SHA1, SHA256, SHA512). Default: SHA256.'
        )->addOption(
            'output',
            null,
            InputOption::VALUE_REQUIRED,
            'Directory where the hash is generated.'
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
        $output->writeln('<comment>Generating signature</comment>');
        $this->validate($input, $output);

        $rutaPhar = $input->getOption('phar');
        $sigtypeaux = $input->getOption('sign-type');
        $saveHashIn = $input->getOption('output');

        $phar = new \Phar($rutaPhar);
        $sigtypeaux = strtoupper($sigtypeaux);
        switch ($sigtypeaux) {
            case 'MD5':
                $signType = \Phar::MD5;
                break;
            case 'SHA1':
                $signType = \Phar::SHA1;
                break;
            case 'SHA256':
                $signType = \Phar::SHA256;
                break;
            case 'SHA512':
                $signType = \Phar::SHA512;
                break;
            default:
                $signType = \Phar::SHA256;
                break;
        }
        $phar->setSignatureAlgorithm($signType);
        $sig = $phar->getSignature();
        $output->writeln("Hash created: ".$sig['hash']);

        if (null !== $saveHashIn) {
            $saveHashIn = rtrim($saveHashIn, '/').'/hash.'.$sigtypeaux;
            file_put_contents($saveHashIn, $sig['hash']);
            $output->writeln('');
            $output->writeln("<info>Hash saved in: </info>".$saveHashIn);
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

        $hashType = strtoupper($input->getOption('sign-type'));
        if (null !== $hashType && !in_array($hashType, ['MD5', 'SHA1', 'SHA256', 'SHA512'])) {
            $output->writeln('<error>Invalid encript type</error>');
            exit(1);
        }

        $dir = $input->getOption('output');
        if (null !== $dir) {
            if (!is_dir($dir) || !is_writable($dir)) {
                $output->writeln('<error>The dir '.$dir.' is not writable</error>');
                exit(1);
            }
        }

    }
}
