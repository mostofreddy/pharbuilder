<?php
/**
 * Buildin.php
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

use Mostofreddy\Phox\Phar\Stub;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Building
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
class Building extends Command
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('build')
            ->setDescription('Create a Phar package')
            ->setOptions();
    }

    protected function setOptions()
    {
        $this->addOption(
            'output',
            null,
            InputOption::VALUE_REQUIRED,
            'REQUIRED - Directory where the file was created'
        )->addOption(
            'alias',
            null,
            InputOption::VALUE_REQUIRED,
            'Alias with which this Phar archive should be referred to in calls to stream functionality'
        )->addOption(
            'src',
            null,
            InputOption::VALUE_REQUIRED,
            'REQUIRED - The full or relative path to the directory that contains all files to add to the archive'
        )->addOption(
            'stub',
            null,
            InputOption::VALUE_REQUIRED,
            'Cli bootstrap. Path relative tu src option'
        )->addOption(
            'stubweb',
            null,
            InputOption::VALUE_REQUIRED,
            'Web bootstrap. Path relative tu src option'
        )->addOption(
            'replace',
            false,
            InputOption::VALUE_NONE,
            'If the file exists, delete it'
        )->addOption(
            'exclude',
            null,
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
            'Excludes a directory'
        );
        return $this;
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
        $output->writeln('<comment>Creating package</comment>');
        $this->validate($input, $output);

        try {
            //get all params
            $rutaPhar = $input->getOption('output');
            $alias = $input->getOption('alias').'.phar';
            $rutaPhar = rtrim($rutaPhar, '/').'/'.$alias;
            $src = $input->getOption('src');
            $stub = $input->getOption('stub');
            $stubweb = $input->getOption('stubweb');
            $replace = $input->getOption('replace');
            $exclude = $input->getOption('exclude');

            if (true === $replace && is_file($rutaPhar)) {
                \Phar::unlinkArchive($rutaPhar);
            }

            //create phar object
            $phar = new \Phar($rutaPhar, 0, $alias);
            $phar->startBuffering();

            //create and setup Stup object
            $oStub = new Stub();
            if (null !== $stub) {
                $oStub->setStubCli($stub);
            }
            if (null !== $stubweb) {
                $oStub->setStubWeb($stubweb);
            }
            $oStub->setDirTmp($src);

            //create default stubs
            $phar->setStub(
                $oStub->createDefaultStub($phar)
            );

            //search files in src directory
            $finder = new Finder();
            $finder->files()
                ->in($src);

            foreach ($exclude as $dirToExclude) {
                $finder->exclude($dirToExclude);
            }

            //inicialize progressbar
            $progress = new ProgressBar($output, count($finder));
            $progress->setBarCharacter('<comment>=</comment>');
            $progress->setProgressCharacter('<comment>></comment>');

            //add all files in the phar object
            $progress->start();
            foreach ($finder as $file) {
                $alias = ltrim(str_replace($src, '', $file->getPathname()), '/');
                $phar->addFile($file, $alias);
                $progress->advance();
            }
            $progress->finish();

            $phar->stopBuffering();

            $oStub->deleteTmpStubs();

            $output->writeln('');
            $output->writeln('');
            $output->writeln("<info>Phar created in: </info>".$rutaPhar);

        } catch (\Exception $e) {
            $output->writeln('<error>'.$e->getMessage()."</error>");
            exit(1);
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
        if (null === $input->getOption('output')) {
            $output->writeln('<error>The parameter output is required</error>');
            exit(1);
        }
        if (null === $input->getOption('src')) {
            $output->writeln('<error>The parameter src is required</error>');
            exit(1);
        }
        $stub = $input->getOption('stub');
        if (null !== $stub) {
            $stub = $input->getOption('src').'/'.$stub;
            if (!is_file($stub) || !is_readable($stub)) {
                $output->writeln("<error>Stub '$stub' is not a file</error>");
                exit(1);
            }
        }
        $stubweb = $input->getOption('stubweb');
        if (null !== $stubweb) {
            $stubweb = $input->getOption('src').'/'.$stubweb;
            if (!is_file($stubweb) || !is_readable($stubweb)) {
                $output->writeln("<error>Stubweb '$stubweb' is not a file</error>");
                exit(1);
            }
        }
    }
}
