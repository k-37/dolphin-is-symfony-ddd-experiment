# Editors and IDEs configuration

## PhpStorm

### Debugging

- [Debugging with Xdebug and PHPStorm](https://github.com/dunglas/symfony-docker/blob/6b37be14c98583e202cbbdec380c6e9e3103d2ab/docs/xdebug.md#debugging-with-xdebug-and-phpstorm)

### Remote interpreter

- On `File > Settings > PHP` we need to add interpreter which is inside container with the option `CLI Interpreter` using  `...` on the right side. For the option `Configuration files` we **must add both** `compose.yaml` and `compose.override.yaml`.
- On `File > Settings > PHP > Composer > Execution > Remote Interpreter > CLI Interpreter` select added interpreter.
- On `File > Settings > PHP > Test Frameworks` click on `+` and select remote interpreter. For the option `Path to script` we **must type** absolute path inside container `/app/vendor/autoload.php` and click refresh button on the right side, for the option `Default configuration file` **type** `/app/phpunit.xml.dist`. The bootstrap file can be skipped because it will be guessed from the config file.

[Detailed instructions with pictures](https://medium.com/the-sensiolabs-tech-blog/phpstorm-docker-ccc4ce9a0b8e). 📸️

### Quality tools

#### PHPStan

- [Configuration and usage with PhpStorm](https://www.jetbrains.com/help/phpstorm/using-phpstan.html).

## Visual Studio Code

### Debugging

#### Requirements

- PHP Debug (`xdebug.php-debug`) extension for VSCode by *Xdebug*.

#### Setup

Create file `.vscode/launch.json` with contents:

    {
        // Use IntelliSense to learn about possible attributes.
        // Hover to view descriptions of existing attributes.
        // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
        "version": "0.2.0",
        "configurations": [
            {
                "name": "Listen for Xdebug",
                "type": "php",
                "request": "launch",
                "port": 9003,
                "pathMappings": {
                    "/app": "${workspaceRoot}"
                }
            }
        ]
    }

To make it possible to go directly to a line and file in VSCode by clicking on the filenames that Xdebug shows in stack traces in Symfony Profiler in `./etc/frankenphp/conf.d/20-app.dev.ini` comment out line starting with `xdebug.file_link_format=` and add this bellow it:

    xdebug.file_link_format='vscode://file/%f:%l&/app><PATH_TO_APP_ON_HOST>'

Path to app in container `/app` will be mapped to `<PATH_TO_APP_ON_HOST>` outside container.

After making changes to `20-app.dev.ini` run `make restart`.

#### Debug

In VSCode [set breakpoint](https://code.visualstudio.com/docs/editor/debugging#_breakpoints), after that in menu click on `Run > Start Debugging`.

Add the `XDEBUG_SESSION=1` query parameter to the URL of the page you want to debug (e.g. [http://localhost/?XDEBUG_SESSION=1](http://localhost/?XDEBUG_SESSION=1)), or use [other available triggers](https://xdebug.org/docs/step_debug#activate_debugger)

Alternatively, you can use [the **Xdebug extension**](https://xdebug.org/docs/step_debug#browser-extensions) for your preferred web browser.
