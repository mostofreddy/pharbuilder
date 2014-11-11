#Phox


[![Build Status](https://travis-ci.org/mostofreddy/phox.svg?branch=master)](https://travis-ci.org/mostofreddy/phox)
[![Latest Stable Version](https://poser.pugx.org/mostofreddy/phox/v/stable.svg)](https://packagist.org/packages/mostofreddy/phox)
[![Total Downloads](https://poser.pugx.org/mostofreddy/phox/downloads.svg)](https://packagist.org/packages/mostofreddy/phox)
[![Latest Unstable Version](https://poser.pugx.org/mostofreddy/phox/v/unstable.svg)](https://packagist.org/packages/mostofreddy/phox)
[![License](https://poser.pugx.org/mostofreddy/phox/license.svg)](https://packagist.org/packages/mostofreddy/phox)
[![Coverage Status](https://coveralls.io/repos/mostofreddy/phox/badge.png?branch=master)](https://coveralls.io/r/mostofreddy/phox?branch=master)

Phox provide a simple way to build, extract and sign Phar files.

##Using Phox
####Running Phox from the command line

    phox build --src=/var/www/my_project --output=/tmp/my_dir [--alias=MyAlias] [--stub=bin/cli.php] [--stubweb=web/server.php] [--replace] [--exclude=tests] [--exclude=docs]

* output: Directory where the file was created. __Required__
* src: The full or relative path to the directory that contains all files to add to the archive. __Required__
* alias: Alias with which this Phar archive should be referred to in calls to stream functionality. Optional
* stub: Cli bootstrap. Path relative tu src option. Optional
* stubweb: Web bootstrap. Path relative tu src option. Optional
* replace: If the file exists, delete it. Optional
* exclude: xcludes a directory. Optional

Example

    php phox build --src=/var/www/my_project --output=/tmp/my_dir

####Extracting files


    phox extract --output=/tmp/my_dir/extract --phar=/tmp/my_dir/MyAlias.phar

* output: Directory where the file will extract. __Required__
* phar: Path to Phar. __Required__

####Signature

    phox sign-create --phar=/tmp/my_dir/MyAlias.phar --output=/tmp/my_dir [--sign-type=SHA256]

* phar: Path to Phar. __Required__
* output: Directory where the hash is generated. __Required__
* sign-type: Hash: MD5, SHA1, SHA256, SHA512. Default: SHA256. Optional

####Validate sign

    phox sign-validate --phar=/tmp/my_dir/MyAlias.phar --sign-file=/tmp/my_dir/hash.SHA256

* phar: Path to Phar. __Required__
* sign: Signature string. Optional
* sign-file: Signature file. Optional


##Current stable version
__1.0.0__

##Install

Phox is able to be installed on your machine or on the server for one of the following ways.

__Globally__

    composer global require "mostofreddy/phox=1.0.0"

If your are working on \*Unix systems you can create a symbolic link.

    cd /usr/bin
    ln -s  ~/.composer/vendor/bin/phox

On Windows environment, you can add the php executble on the environment variables. You have to call phox on this way:
    
    php phox build..... 
    
__Composer__
Adding the dependency on composer.json

    "require": {
        "mostofreddy/phox": "1.0.0"
        ...
    }

__Download__
You can download the last stable version from https://github.com/mostofreddy/phox/releases/download/1.0.0/phox.phar



##License
The [MIT License](http://opensource.org/licenses/MIT) ([MIT](http://opensource.org/licenses/MIT)). Please see [License File](https://github.com/mostofreddy/phox/blob/master/LICENSE.md) for more information.

##Issues
Before reporting a problem, please read how to [File an issue](https://github.com/mostofreddy/phox/issues).
