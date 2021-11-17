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
    your-vendor/package:
        target: '/absolute/path/to/your/target/folder'
        link: '/absolute/path/to/your/symlink/folder'
        pimcore-assets-link: '/<serverroot>/<web|public>/bundles/<bundlename>' # This is optional and just for Pimcore!
```
The **target** is the folder where your package development is done (maybe "/libs" or "/dev"). **link** is the symlink folder, where the package, which is under development, would be installed by composer normally (maybe "/vendor/namespace/your-package").

### Environment file
Add environment file (dotenv) to your root path:
"/.env" - Environment file; minimum content is `COMPOSERHELPER=prod` or `COMPOSERHELPER=dev` depending on your environment. Don't forget to add .env file to your .gitignore!

Yout can add other parameters to .env as you like.

### composer.json Scripts
Extend the "scripts" section in your composer.json like this:
```json
...
"scripts": {
    "post-install-cmd": [
       ...
       "ComposerHelper\\ComposerHelper::postInstall"
    ],
    "post-update-cmd": [
      ...
      "ComposerHelper\\ComposerHelper::postUpdate"
    ],
},
...
```

After doing all the configuration stuff, you can start using the package. The pre- and postInstall scripts are called **directly** by a `composer install`. You will see some status messages in the console and symlinks in your **link** folder. Keep an eye on messages like "Composer helper message: ...".
