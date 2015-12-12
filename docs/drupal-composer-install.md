# Composer Installer for Drupal

When switching to a composer based Drupal development workflow, composer needs to know where to put the various types of Drupal dependencies e.g. modules, themes, libraries, etc. For this we're going to use [composer installer](https://github.com/composer/installers).

If you want to know how to use it as replacement for
[Drush Make](https://github.com/drush-ops/drush/blob/master/docs/make.md) visit
the [Documentation on drupal.org](https://www.drupal.org/node/2471553).

## Usage

### Creating a new project
First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

> Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
You might need to replace `composer` with `php composer.phar` (or similar) for your setup.

After that you can create the project:

```
composer create-project drupal-composer/drupal-project:8.x-dev project-dir --stability dev --no-interaction
```

This downloads Drupal and all of its dependencies and places the Drupal root into a `web` directory. This can also work with Drupal 7 just by defining the version t0 7.x-dev

### Adding Additional Dependencies

With `composer require ...` you can download new dependencies to your installation.

```
cd project-dir
composer require drupal/devel:8.*
```

This will add devel and its dependencies to your composer.json file, download the packages, and install them to the appropriate directory. In the case of Drupal 8 `web/modules/contrib/`.

### Adding Libraries Not Hosted by Packagist

Packages that are not hosted on packagist can be added by creating an inline composer object in the [repositories](https://getcomposer.org/doc/04-schema.md#repositories) section.

```
"repositories": [
    {
      "type": "package",
      "package": {
        "name": "jquery/jqueryui",
        "version": "1.10.4",
        "type": "drupal-library",
        "dist": {
          "url": "http://jqueryui.com/resources/download/jquery-ui-1.10.4.zip",
          "type": "zip"
        }
      }
    }
```

This will add jquery as a dependency to the project. By specifying the package type of drupal-library the composer installer can know where this project belongs in the Drupal Root `web/sites/all/libraries/`

## What does the template do?

When installing the given `composer.json` some tasks are taken care of:

* Drupal will be installed in the `web`-directory.
* Autoloader is implemented to use the generated composer autoloader in `vendor/autoload.php`,
  instead of the one provided by Drupal (`web/vendor/autoload.php`).
* Modules (packages of type `drupal-module`) will be placed in `web/modules/contrib/`
* Theme (packages of type `drupal-theme`) will be placed in `web/themes/contrib/`
* Profiles (packages of type `drupal-profile`) will be placed in `web/profiles/contrib/`
* Creates default writable versions of `settings.php` and `services.yml`.
* Creates `sites/default/files`-directory.
* Latest version of drush is installed locally for use at `vendor/bin/drush`.
* Latest version of DrupalConsole is installed locally for use at `vendor/bin/console`.

## Updating Drupal Core

Updating Drupal core is a two-step process.

1. Update the version number of `drupal/core` in `composer.json`.
1. Run `composer update drupal/core`.
1. Run `./scripts/drupal/update-scaffold [drush-version-spec]` to update files
   in the `web` directory, where `drush-version-spec` is an optional identifier
   acceptable to Drush, e.g. `drupal-8.0.x` or `drupal-8.1.x`, corresponding to
   the version you specified in `composer.json`. (Defaults to `drupal-8`, the
   latest stable release.) Review the files for any changes and restore any
   customizations to `.htaccess` or `robots.txt`.

### Should I commit the contrib modules I download

Composer recommends **no**. They provide [argumentation against but also workrounds if a project decides to do it anyway](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

### How can I apply patches to downloaded modules?

If you need to apply patches (depending on the project being modified, a pull request is often a better solution), you can do so with the [composer-patches](https://github.com/cweagans/composer-patches) plugin.

To add a patch to drupal module foobar insert the patches section in the extra section of composer.json:
```json
"extra": {
    "patches": {
        "drupal/foobar": {
            "Patch description": "URL to patch"
        }
    }
}
