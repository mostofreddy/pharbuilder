<?php
/**
 * StubTest
 *
 * PHP version 5.3+
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Phar
 * @package   Mostofreddy/Phar/Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
/**
 * StubTest
 *
 * Copyright (c) 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * @category  Phar
 * @package   Mostofreddy/Phar/Tests
 * @author    Federico Lozada Mosto <mosto.federico@gmail.com>
 * @copyright 2014 Federico Lozada Mosto <mosto.federico@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link      http://www.mostofreddy.com.ar
 */
class StubTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test method enableCli
     * @return void
     */
    public function testEnableCli()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->enableCli(true);
        $this->assertAttributeEquals(true, 'enableCli', $stub);

        $stub->enableCli(false);
        $this->assertAttributeEquals(false, 'enableCli', $stub);

        $stub->enableCli('asdsd');
        $this->assertAttributeEquals(false, 'enableCli', $stub);
    }
    /**
     * Test method enableWeb
     * @return void
     */
    public function testEnableWeb()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->enableWeb(true);
        $this->assertAttributeEquals(true, 'enableWeb', $stub);

        $stub->enableWeb(false);
        $this->assertAttributeEquals(false, 'enableWeb', $stub);

        $stub->enableWeb('asdsd');
        $this->assertAttributeEquals(false, 'enableWeb', $stub);
    }
    /**
     * Test method setStubCli
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid file
     *
     * @return void
     */
    public function testSetStubCliThrowException()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->setStubCli('');
    }
    /**
     * Test method setStubCli
     *
     * @return void
     */
    public function testSetStubCli()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->setStubCli(__FILE__);
        $this->assertAttributeEquals(__FILE__, 'stubCli', $stub);
    }
    /**
     * Test method setStubWeb
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid file
     *
     * @return void
     */
    public function testSetStubWebThrowException()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->setStubWeb('');
    }
    /**
     * Test method setStubWeb
     *
     * @return void
     */
    public function testSetStubWeb()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->setStubWeb(__FILE__);
        $this->assertAttributeEquals(__FILE__, 'stubWeb', $stub);
    }

    /**
     * Test method setStubWeb
     *
     * @expectedException \Exception
     * @expectedExceptionMessage Stub dir is not writable
     *
     * @return void
     */
    public function testSetDirTmpThrowException()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->setDirTmp('');
    }
    /**
     * Test method setStubWeb
     *
     * @return void
     */
    public function testSetDirTmp()
    {
        $stub = new \Mostofreddy\Phox\Phar\Stub();
        $stub->setDirTmp(__DIR__);
        $this->assertAttributeEquals(__DIR__, 'dirTmp', $stub);
    }
}
