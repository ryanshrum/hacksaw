<?php
/**
 * Hacksaw plugin for Craft CMS
 *
 * A simple text truncation plugin for Craft CMS.
 *
 * @author    Ryan Shrum
 * @copyright Copyright (c) 2016 Ryan Shrum
 * @link      ryanshrum.com
 * @package   Hacksaw
 * @since     2.0.1
 */

namespace Craft;

class HacksawPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Hacksaw');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('A simple text truncation plugin for Craft CMS.');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/ryanshrum/hacksaw/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/ryanshrum/hacksaw/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '2.0.1';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '2.0.1';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Ryan Shrum';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'ryanshrum.com';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function addTwigExtension()
    {
        Craft::import('plugins.hacksaw.twigextensions.HacksawTwigExtension');

        return new HacksawTwigExtension();
    }
}
