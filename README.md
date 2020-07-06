# Composer Helper Package
This package is ment as an useful library, making your developer days a little bit more sunny ;-).

## Installation
```bash
composer require abytemore/composer-helper
```

## Configuration
Add a #composer-helper.yaml# file to the root folder of your application. The content looks like:
```yaml
composer-helper:
  abytemore:
    target: '/absolute/path/to/target/folder'
    link: '/absolute/path/to/symlink'
```

Extend the "scripts" section in your composer.json like this:
```json
...
"scripts": {
    "post-install-cmd": [
      "abytemore\\ComposerHelper:postInstall"
    ],
    "pre-install-cmd": [
      "abytemore\\ComposerHelper:PreInstall"
    ],
    ...
  },
  ...
```
