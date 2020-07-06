# Composer Helper Package
This package is ment as an useful library, making your developer days a little bit more sunny ;-).

## Installation
```bash
composer require abytemore/composer-helper
```

## Configuration
Add a **composer-helper.yaml** file to the root folder of your application. The content looks like:
```yaml
composer-helper:
  abytemore:
    target: '/absolute/path/to/target/folder'
    link: '/absolute/path/to/symlink'
```
The **target** is the folder where your package development is done (maybe "/libs"). **link** is the symlink folder, where the package, which is under development, would be installed by composer normally (maybe "/vendor/namespace/your-package").


Extend the "scripts" section in your composer.json like this:
```json
...
"scripts": {
    "post-install-cmd": [
      "abytemore\\ComposerHelper:postInstall"
    ],
    "pre-install-cmd": [
      "abytemore\\ComposerHelper:preInstall"
    ],
    ...
},
...
```

After doing the all the configuration stuff, you can start using the package. The pre- and postInstall scripts are called directly by a `composer install`. You will see some status messages in the console. Keep an eye on messages like "Composer helper message: ...".
