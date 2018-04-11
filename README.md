**DEPRECATED**

#Phox


[![Build Status](https://travis-ci.org/mostofreddy/phox.svg?branch=master)](https://travis-ci.org/mostofreddy/phox)
[![Latest Stable Version](https://poser.pugx.org/mostofreddy/phox/v/stable.svg)](https://packagist.org/packages/mostofreddy/phox)
[![Total Downloads](https://poser.pugx.org/mostofreddy/phox/downloads.svg)](https://packagist.org/packages/mostofreddy/phox)
[![Latest Unstable Version](https://poser.pugx.org/mostofreddy/phox/v/unstable.svg)](https://packagist.org/packages/mostofreddy/phox)
[![License](https://poser.pugx.org/mostofreddy/phox/license.svg)](https://packagist.org/packages/mostofreddy/phox)
[![Coverage Status](https://coveralls.io/repos/mostofreddy/phox/badge.png?branch=master)](https://coveralls.io/r/mostofreddy/phox?branch=master)

Phox provide a simple way to build, extract and sign Phar files.

## Current stable version
__1.1.0__

## Install

Phox is able to be installed on your machine or on the server for one of the following ways.

### Globally

    composer global require "mostofreddy/phox=1.0.0"

If your are working on \*Unix systems you can create a symbolic link.

    cd /usr/bin
    ln -s  ~/.composer/vendor/bin/phox

On Windows environment, you can add the php executble on the environment variables. You have to call phox on this way:

    php phox build.....

### Composer
Adding the dependency on composer.json

    "require": {
        "mostofreddy/phox": "1.0.0"
        ...
    }

### Download
You can download the last stable version from https://github.com/mostofreddy/phox/releases/download/1.0.0/phox.phar

## License
The [MIT License](http://opensource.org/licenses/MIT) ([MIT](http://opensource.org/licenses/MIT)). Please see [License File](https://github.com/mostofreddy/phox/blob/master/LICENSE.md) for more information.

## Issues
Before reporting a problem, please read how to [File an issue](https://github.com/mostofreddy/phox/issues).

## Using Phox

### Running Phox from the command line

    phox build --src=/var/www/my_project --output=/tmp/my_dir [--alias=MyAlias] [--stub=bin/cli.php] [--stubweb=web/server.php] [--replace] [--exclude=tests] [--exclude=docs]

* output: __REQUIRED__ The full or relative path to the directory that contains all files to add.
* src: __REQUIRED__ Output directory for phar file.
* alias: Alias with which this Phar archive should be referred to in calls to stream functionality.
* stub: Path to the php file to call when Phar file is running from command line. Example: --stubweb=src/mainStubCli.php.
* stubweb: Endpoint file when the Phar file is running as a site on server (ex: virtal host on Apache or server block in Nginx). Example: --stubweb=src/mainStubWeb.php.
* replace: If the file exists, delete it.
* exclude: Directory exclusion (ex: --exclude=tests --exclude=docs). (multiple values allowed)

Example

    php phox build --src=/var/www/my_project --output=/tmp/my_dir

### Extracting files


    phox extract --output=/tmp/my_dir/extract --phar=/tmp/my_dir/MyAlias.phar

* output: __REQUIRED__ Output directory to extract the files.
* phar: __REQUIRED__ Path to Phar file.

### Signature

    phox sign-create --phar=/tmp/my_dir/MyAlias.phar --output=/tmp/my_dir [--encrypt-type=SHA256]

* phar: __REQUIRED__ Path to Phar.
* encrypt-type: Encryption algorithm (MD5, SHA1, SHA256, SHA512). Default: SHA256.
* output: Directory where the hash is generated.

####Validate sign

    phox sign-validate --phar=/tmp/my_dir/MyAlias.phar --sign-file=/tmp/my_dir/hash.SHA256

* phar: __REQUIRED__ Path to Phar
* hash-string: Hash string created when the Phar file was signed.
* hash-file: Path to the hash file created when the Phar was signed.
