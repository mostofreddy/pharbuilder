<?php
/**
 * Stub.php
 *
 * PHP version 5.3+
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Phox
 * @package   Phox/Phar
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
namespace Mostofreddy\Phox\Phar;

/**
 * Stub
 *
 * Create default stub
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed
 * with this source code.
 *
 * @category  Phox
 * @package   Phox/Phar
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class Stub
{
    protected $dirTmp = '';
    protected $stubCli = null;
    protected $stubWeb = null;
    protected $enableCli = true;
    protected $enableWeb = true;
    protected $createdCli = false;
    protected $createdWeb = false;
    protected $defaultNameCli = 'cli.php';
    protected $defaultNameWeb = 'web.php';

    /**
     * Enable create cli stub
     *
     * @param bool $bool true|false
     *
     * @return self
     */
    public function enableCli($bool)
    {
        $this->enableCli = is_bool($bool)?$bool:false;
        return $this;
    }
    /**
     * Enable create web stub
     *
     * @param bool $bool true|false
     *
     * @return self
     */
    public function enableWeb($bool)
    {
        $this->enableWeb = is_bool($bool)?$bool:false;
        return $this;
    }
    /**
     * Set file for cli stub
     *
     * @param string $stub relative path to file
     *
     * @return self
     */
    public function setStubCli($stub)
    {
        $this->stubCli = $stub;
        return $this;
    }
    /**
     * Set file for web stub
     *
     * @param string $stub relative path to file
     *
     * @return self
     */
    public function setStubWeb($stub)
    {
        $this->stubWeb = $stub;
        return $this;
    }
    /**
     * Directory for create default stub if no defined setStubCli or setStubWeb.
     *
     * @param string $dir path to dir
     *
     * @return self
     */
    public function setDirTmp($dir)
    {
        if (!is_dir($dir) || !is_writable($dir)) {
            throw new \Exception("Dir $dir is not writable");
        }
        $this->dirTmp = $dir;
        return $this;
    }
    /**
     * Create default stubs
     *
     * @param \Phar $phar Phar instance
     *
     * @return string
     */
    public function createDefaultStub(\Phar $phar)
    {
        $this->createStubCli();
        $this->createStubWeb();
        return $phar->createDefaultStub($this->stubCli);
    }
    /**
     * Set & create Cli Stub
     *
     * @return self
     */
    protected function createStubCli()
    {
        if ($this->enableCli) {
            if (null === $this->stubCli) {
                $this->stubCli = $this->createEmptyDefault($this->defaultNameCli);
                $this->createdCli = true;
            }
        } else {
            $this->stubCli = null;
        }
        return $this;
    }
    /**
     * Set & create Web Stub
     *
     * @return self
     */
    protected function createStubWeb()
    {
        if ($this->enableWeb) {
            if (null === $this->stubWeb) {
                $this->stubWeb = $this->createEmptyDefault($this->defaultNameWeb);
                $this->createdWeb = true;
            }
        } else {
            $this->stubWeb = null;
        }
    }
    /**
     * Create default stub
     *
     * @param string $name file name
     *
     * @return string
     */
    protected function createEmptyDefault($name)
    {
        $content = <<<TXT
<?php
echo "";
TXT;
        file_put_contents($this->dirTmp.'/'.$name, $content);
        return $name;
    }
    /**
     * Delete stub if automated created
     *
     * @return void
     */
    public function deleteTmpStubs()
    {
        if ($this->createdCli) {
            unlink($this->dirTmp.'/'.$this->defaultNameCli);
        }
        if ($this->createdWeb) {
            unlink($this->dirTmp.'/'.$this->defaultNameWeb);
        }
    }
}
