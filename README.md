# kirby-pug

Phug templating support for Kirby CMS. This relies on (Pug-php)[https://github.com/pug-php/pug], and I have found it a joy to use. As it stands it uses the php expressionLanguage, and comes pre-installed with coffee-script and less filters.

## Installation

Clone this in your `site/plugins` folder and run

    composer install

from there.

## Usage

Simply convert your templates to `.pug` files. Their translation to Php files will happen automatically whenever any of the files (and dependencies, ie through the use of `extends`) are changed, and cached in the plugins `cache` folder.

## Contributing

This is a really bare-bones implementation. One could imagine many extensions (configuration, easier installation, etc.).  This does what I need it to do, so I don't expect that I will expand upon it massively by my own initiative. Feel free to submit PR's, and I will gladly follow up.

Or fork it if you feel like taking ownership — I will then redirect.
