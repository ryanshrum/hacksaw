# Hacksaw for Craft CMS

A simple text truncation plugin for [Craft CMS](https://craftcms.com/) that takes your content and hacks it down to more manageable sizes.

## Installation

To install Hacksaw, follow these steps:

1. Download & unzip the file and place the `hacksaw` directory into your `craft/plugins` directory<br>**-OR-**<br> Do a `git clone https://github.com/ryanshrum/hacksaw.git` directly into your `craft/plugins` folder.  You can then update it with `git pull` <br>**-OR-**<br> Install with Composer via `composer require ryanshrum/hacksaw`
1. Install plugin in the Craft Control Panel under Settings > Plugins
1. The plugin folder should be named `hacksaw` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

## Usage

Hacksaw is a Twig filter that accepts the following parameters:

| Parameter     | Type      | Default   | Description                                                                                                       |
| ------------- | :-------: | :-------: | ----------------------------------------------------------------------------------------------------------------- |
| hack          | string    | `'p'`       | What you want to hack on (`'characters'`, `'words'` or `'paragraphs'` - can also use first letter as short hand `'c'`, `'w'` or `'p'`)   |
| limit         | int       | `1`         | Starting point for chars limit (used with chars param)                                                            |
| allow         | string    | `null`    | Sometimes there are HTML tags in your content that you don' removed, pass them here                               |
| append        | string    | `null`    | String to append to the end of the excerpt                                                                        |

_**Note:** Cutoff has been deprecated from Hackasw._

## Examples

Hacking by paragraphs is default, so if you wanted to limit your text to 5 paragraphs, you would only need to set the limit parameter:

```
{{ entry.richTextField|hacksaw(limit='5') }}
```

If you wanted to limit to 50 characters or words, you'd use both the hack and limit parameter:

```
{{ entry.richTextField|hacksaw(hack='characters', limit='50') }}
```

```
{{ entry.richTextField|hacksaw(hack='words', limit='50') }}
```

Hacksaw will strip all HTML from your excerpt by default. If you would like to keep some basic HTML you can use the `allow` parameter to keep specific HTML tags. For example, let's say you want to keep `<a>` and `<b>` tags:

_**Note:** `<p>`'s are automatically allowed when hacking by paragraph._

```
{{ entry.richTextField|hacksaw(limit='10', allow='<a><b>') }}
```

**Note:** If you are including HTML in the append parameter, the elements must be present in the `allow` parameter. If you are including a Craft variable in any parameter, it must be added using the Twig concatenation operator, `~`. Example of both:

```
{{ entry.richTextField|hacksaw(hack='w', limit='100', allow='<a>', append='<a href="' ~ entry.url ~ '">Continue...</a>') }}
```

Brought to you by [Ryan Shrum](http://ryanshrum.com)
