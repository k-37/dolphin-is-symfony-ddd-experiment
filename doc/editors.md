# PhpStorm

### Debugging

- [Debugging with Xdebug and PHPStorm](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/xdebug.md#debugging-with-xdebug-and-phpstorm)

### Remote interpreter

- On `File > Settings > PHP` we need to add interpreter which is inside container with the option `CLI Interpreter` using  `...` on the right side. For the option `Configuration files` we **must add both** `compose.yaml` and `compose.override.yaml`.
- On `File > Settings > PHP > Composer > Execution > Remote Interpreter > CLI Interpreter` select added interpreter.
- On `File > Settings > PHP > Test Frameworks` click on `+` and select remote interpreter. For the option `Path to script` we **must type** absolute path inside container `/app/vendor/autoload.php` and click refresh button on the right side, for the option `Default configuration file` **type** `/app/phpunit.xml.dist`. The bootstrap file can be skipped because it will be guessed from the config file.

[Detailed instructions with pictures](https://medium.com/the-sensiolabs-tech-blog/phpstorm-docker-ccc4ce9a0b8e). 📸️
