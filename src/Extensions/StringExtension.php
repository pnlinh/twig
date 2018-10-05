<?php

namespace Qh\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('append', [$this, 'append']),
            new TwigFilter('prepend', [$this, 'prepend']),
            new TwigFilter('camelcase', 'camel_case'),
            new TwigFilter('camel_case', 'camel_case'),
            new TwigFilter('kebabcase', 'kebab_case'),
            new TwigFilter('kebab_case', 'kebab_case'),
            new TwigFilter('snakecase', 'snake_case'),
            new TwigFilter('snake_case', 'snake_case'),
            new TwigFilter('studlycase', 'studly_case'),
            new TwigFilter('studly_case', 'studly_case'),
            new TwigFilter('downcase', 'twig_lower_filter', ['needs_environment' => true]),
            new TwigFilter('upcase', 'twig_upper_filter', ['needs_environment' => true]),
            new TwigFilter('hanle', 'str_slug'),
            new TwigFilter('handleize', 'str_slug'),
            new TwigFilter('slug', 'str_slug'),
            new TwigFilter('base64_encode', 'base64_encode'),
            new TwigFilter('base64_encode', 'base64_encode'),
            new TwigFilter('md5', 'md5'),
            new TwigFilter('sha1', 'sha1'),
            new TwigFilter('sha256', [$this, 'sha256']),
            new TwigFilter('hmac_sha1', [$this, 'hmacSha1']),
            new TwigFilter('hmac_sha256', [$this, 'hmacSha256']),
            new TwigFilter('newline_to_br', 'nl2br', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFilter('pluralize', [$this, 'pluralize']),
            new TwigFilter('remove', [$this, 'removeString']),
            new TwigFilter('remove_first', [$this, 'removeStringFirst']),
            new TwigFilter('replace', [$this, 'replaceString']),
            new TwigFilter('replace_first', [$this, 'replaceStringFirst']),
            new TwigFilter('strip', 'trim'),
            new TwigFilter('lstrip', 'ltrim'),
            new TwigFilter('rstrip', 'rtrim'),
            new TwigFilter('strip_html', 'strip_tags'),
            new TwigFilter('strip_newlines', [$this, 'stripNewlines']),
            new TwigFilter('truncate', 'str_limit'),
            new TwigFilter('url_encode', 'url_encode'),
            new TwigFilter('url_decode', 'url_decode'),
            new TwigFilter('json', 'json_encode', ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new TwigFilter('ends_with', 'ends_with'),
            new TwigFilter('starts_with', 'starts_with'),
            new TwigFilter('str_*', function ($name) {
                $arguments = array_slice(func_get_args(), 1);
                if (function_exists($name = "str_{$name}")) {
                    return call_user_func_array($name, $arguments);
                }
                return null;
            })
        ];
    }

    protected function append($str, $appendText = null)
    {
        return "{$str}{$appendText}";
    }

    protected function prepend($str, $rependText = null)
    {
        return "{$rependText}{$str}";
    }

    protected function sha256($str)
    {
        return hash('sha256', $str);
    }

    protected function hmac($algo, $str, $secret)
    {
        return hash_hmac($algo, $str, $secret);
    }

    protected function hmacSha1($str, $secret)
    {
        return $this->hmac('sha1', $str, $secret);
    }

    protected function hmacSha256($str, $secret)
    {
        return $this->hmac('sha256', $str, $secret);
    }

    protected function pluralize($count, $str)
    {
        return $count.' '.str_plural($str);
    }

    protected function removeString($str, $removedStr)
    {
        return str_replace($removedStr, '', $str);
    }

    protected function removeStringFirst($str, $removedStr)
    {
        return preg_replace('/'.preg_quote($removedStr,'/').'/', '', $str, 1);
    }

    protected function replaceString($str, $search, $replace)
    {
        return str_replace($search, $replace, $str);
    }

    protected function replaceStringFirst($str, $search, $replace)
    {
        return preg_replace('/'.preg_quote($search,'/').'/', $replace, $str, 1);
    }

    protected function stripNewlines($str)
    {
        return preg_replace("/\r|\n/", '', $str);
    }
}
