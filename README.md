# Composer Helper Package
This package is ment as an useful library, making your developer days a little bit more sunny ;-).
At the moment the most important feature is moving package or bundle development from "/vendor" folder to an extra folder in your application. The `require` section of your composer.yml is untouched so deployment keeps consistent.
Handle the packages in your development folder like completely isolatet git repos.

## Installation
```bash
composer require abytemore/composer-helper
```

## Configuration
Add a **composer-helper.yml** file to the root folder of your application. The content looks like:
```yaml
packages:
    your-vendor:
        target: '/absolute/path/to/your/target/folder'
        link: '/absolute/path/to/your/symlink/folder'
        pimcore-assets-link: '/<serverroot>/web/bundles/<bundlename>' # This is optional and just for Pimcore!
```
The **target** is the folder where your package development is done (maybe "/libs"). **link** is the symlink folder, where the package, which is under development, would be installed by composer normally (maybe "/vendor/namespace/your-package").

### Environment files
Add two environment files (dotenv) files to your root path:
1. "/.env" - Productive environment file; minimum content is `ENVIRONMENT=prod`
2. "/.env.dev" - Development environment file (__NOTE: add this file to your .gitignore!__), minimum content is `ENVIRONMENT=dev`

### composer.json Scripts
Extend the "scripts" section in your composer.json like this (special thanks to neronmoon/scriptsdev at this point!):
```json
...
"scripts": {
    "post-install-cmd": [
       ...
       "abytemore\\ComposerHelper:postInstall"
    ],
    "pre-install-cmd": [
      ...
      "abytemore\\ComposerHelper:preInstall"
    ],
    "post-update-cmd": [
      ...
      "abytemore\\ComposerHelper\\ComposerHelper::postUpdate"
    ],
},
...
```

After doing all the configuration stuff, you can start using the package. The pre- and postInstall scripts are called **directly** by a `composer install`. You will see some status messages in the console and symlinks in your **link** folder. Keep an eye on messages like "Composer helper message: ...".
