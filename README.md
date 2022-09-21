## Developer Setup

This repo is configured for VS Code, notably including extensions and settings that run Prettier on `.scss` and `.php` files. We also have a number of [tasks](https://code.visualstudio.com/docs/editor/tasks) that we refer to by name. If you are using a different editor, then you can always look at the .vscoded/tasks.json to map those to the underlying shell commands.

## Getting up and running

1. Clone this repo.
2. Duplicate .env.sample to .env, customize values for project if needed
3. Initiate Docker, by running the `WordPress Docker Recreate` task.
4. Add node/gulp dependencies by running `yarn install`.

That should be it. You can build your theme assets by running `Gulp Dev` task, then go to the URL in your console to see the site. Note that this will be an empty WordPress site, see below for importing content.

## Exporting and Importing database

We have an import script that will grab the most recent folder from a root level `_data` folder that is otherwise gitignored.

On top of that import, a few modifications for localhosting will be run. These live in `_init/local.sql`, and those should be copied to the `_data` folder.

After copying that `local.sql` file, export your DB from production (check the boxes to add drop tables), and save it into the `_data` folder. Import by running `WordPress DB Import` task.

Your wordpress admin will be viewable at /wp-login.php, and you can use the username: `admin` and password: `password`.

To help with exports, we also have tasks "Wordpress DB Export" for both production and staging that will save the latest DB to the \_data folder. You will need a local version of [WP CLI](https://wp-cli.org/) in order for this to work.

## Editng up the theme

All assets are stored in `wp-content/themes/timber`.

For vendor libraries, we install with NPM. There is a symlink that gets installed via the `postinstall` task after you install deps that aliases those all of those files from a vendor folder inside of `timber/assets/vendor`.

## Deploying

The `_build` folder has our deploy scripts:

- to manually deploy to staging from your current branch, run `./_build/deploy.sh staging`
- to manually deploy to production from your current branch, run `./_build/deploy.sh production`

During the deploy process `gulp release` will run using JSHint which will alert you in the terminal for any warnings/errors. We are only looking at js files in the `build:js` block of `layout.twig` and we have it set to skip any `/vendor` js files.

Gulp will fail if there are any warnings/errors, some of which you may want to ignore which you can do with the following comments:

```
A directive for telling JSHint to ignore a block of code.

// Code here will be linted with JSHint.
/* jshint ignore:start */
// Code here will be ignored by JSHint.
/* jshint ignore:end */

All code in between ignore:start and ignore:end won't be passed to JSHint so you can use any language extension such as Facebook React. Additionally, you can ignore a single line with a trailing comment:

ignoreThis(); // jshint ignore:line
```

You can read more about [JSHint here](https://jshint.com/docs/)

## Based on Bubs

This project is based on [Bubs](https://github.com/patronage/bubs-timber/) by [Patronage](http://www.patronage.org/).

For more docs on getting started with local hosting, multi-site, etc. visit the wiki:
https://github.com/patronage/bubs-timber/wiki
