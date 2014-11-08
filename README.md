Phox
====

A tool for simplifying the PHAR build, extract and signature process.

Version
=======

__0.2.0__

How is it used?
===============

Build
-----

./phox build --output=/tmp/my_dir --alias=MyAlias --src=/var/www/my_project [--stub=bin/cli.php] [--stubweb=web/server.php] [--replace] [--exclude=tests] [--exclude=docs]


* output: Directory where the file was created. __Required__
* src: The full or relative path to the directory that contains all files to add to the archive. __Required__
* alias: Alias with which this Phar archive should be referred to in calls to stream functionality. Optional
* stub: Cli bootstrap. Path relative tu src option. Optional
* stubweb: Web bootstrap. Path relative tu src option. Optional
* replace: If the file exists, delete it. Optional
* exclude: xcludes a directory. Optional


Extract
-------

./phox extract --output=/tmp/my_dir/extract --phar=/tmp/my_dir/MyAlias.phar

* output: Directory where the file will extract. __Required__
* phar: Path to Phar. __Required__

Signature
---------

./phox sign-create --phar=/tmp/my_dir/MyAlias.phar --output=/tmp/my_dir [--sign-type=SHA256]

* phar: Path to Phar. __Required__
* output: Directory where the hash is generated. __Required__
* sign-type: Hash: MD5, SHA1, SHA256, SHA512. Default: SHA256. Optional

Validate sign
-------------

./phox sign-validate --phar=/tmp/my_dir/MyAlias.phar --sign-file=/tmp/my_dir/hash.SHA256

* phar: Path to Phar. __Required__
* sign: Signature string. Optional
* sign-file: Signature file. Optional
