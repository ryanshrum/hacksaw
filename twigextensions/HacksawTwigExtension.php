<?php
/**
 * Hacksaw plugin for Craft CMS
 *
 * Hacksaw Twig Extension
 *
 * @author    Ryan Shrum
 * @copyright Copyright (c) 2016 Ryan Shrum
 * @link      ryanshrum.com
 * @package   Hacksaw
 * @since     2.0.1
 */

namespace Craft;

use Twig_Extension;
use Twig_Filter_Method;

class HacksawTwigExtension extends \Twig_Extension
{
    /**
     * @return string The extension name
     */
    public function getName()
    {
        return 'Hacksaw';
    }

    public function getFilters()
    {
        return array(
            'hacksaw' => new \Twig_Filter_Method($this, 'hacksaw', [
                'is_safe' => array('html')
            ]),
        );
    }

    public function hacksaw($content, $hack = 'p', $limit = 1, $allow = null, $append = null)
    {
        if ($hack == 'c' || $hack == 'chars' || $hack == 'characters')
        {
            $clean_content = $this->cleanHtml($content, $allow);

            if (mb_strlen($clean_content) <= $limit)
            {
                $return = $clean_content;
            }
            else
            {
                $return = preg_replace('/\s+?(\S+)?$/u', '', mb_substr($clean_content, 0, $limit)) . $append;
            }

            return $this->closeTags($return);

        }
        else if ($hack == 'w' || $hack == 'words')
        {
            $clean_content = $this->cleanHtml($content, $allow);

            if (str_word_count($clean_content) <= $limit)
            {
                $return = $clean_content;
            }
            else
            {
                $word_count = str_word_count($clean_content, 0);

                if ($word_count > $limit)
                {
                    $words = preg_split('/\s+/u', $clean_content);
                    $clean_content = implode(' ', array_slice($words, 0, $limit));
                    $return = $clean_content;

                    if (preg_match("/[0-9.!?,;:]$/u", $clean_content))
                    {
                        $return = mb_substr($clean_content, 0, -1);
                    }

                    $return .= $append;
                }
            }

            return $this->closeTags($return);
        }
        else if ($hack = 'p' || $hack == 'paragraphs')
        {
            $clean_content = $this->cleanHtml($content, $allow . "<p>");
            $paragraphs = array_filter(explode("<p>", str_replace("</p>", "", $content)));
            $paragraphs = array_slice($paragraphs, 0, $limit);
            $paragraphs_count = count($paragraphs)-1;

            $return = "<p>";

            foreach ($paragraphs as $key => $paragraph)
            {
                $return .= "<p>" . $paragraph;

                if ($key < $paragraphs_count)
                {
                    $return .= "</p>";
                }
            }

            $return .= $append . "</p>";

            return $return;
        }
    }

    private function cleanHtml($content, $allow)
    {
        return strip_tags($content, $allow);
    }

    private function closeTags($content) {
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $content, $result);

        $opened_tags = $result[1];

        preg_match_all('#</([a-z]+)>#iU', $content, $result);

        $closed_tags = $result[1];
        $open_tag_count = count($opened_tags);

        if (count($closed_tags) == $open_tag_count) {
            return $content;
        }

        $opened_tags = array_reverse($opened_tags);

        for ($i=0; $i < $open_tag_count; $i++) {
            if (!in_array($opened_tags[$i], $closed_tags)) {
                $content .= '</'.$opened_tags[$i].'>';
            } else {
                unset($closed_tags[array_search($opened_tags[$i], $closed_tags)]);
            }
        }

        return $content;
    }
}
