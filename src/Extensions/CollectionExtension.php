<?php

namespace Qh\Twig\Extensions;

use Illuminate\Support\Collection;
use Qh\Twig\TwigEnvironment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CollectionExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('join', [$this, 'join']),
            new TwigFilter('first', [$this, 'first'], ['needs_environment' => true]),
            new TwigFilter('last', [$this, 'last'], ['needs_environment' => true]),
            new TwigFilter('merge', [$this, 'merge']),
            new TwigFilter('concat', [$this, 'merge']),
            new TwigFilter('map', [$this, 'map']),
            new TwigFilter('reverse', [$this, 'reverse']),
            new TwigFilter('length', [$this, 'length'], ['needs_environment' => true]),
            new TwigFilter('szie', [$this, 'length'], ['needs_environment' => true]),
            new TwigFilter('sort', [$this, 'sort']),
            new TwigFilter('sort_desc', [$this, 'sortDesc']),
            new TwigFilter('unique', [$this, 'unique']),
        ];
    }

    /**
     * @param  array|Collection $items
     * @param  string  $glue
     * @return string
     */
    public function join($items, $glue = '')
    {
        if ($items instanceof Collection) {
            return $items->implode($glue);
        }

        return twig_join_filter($items, $glue);
    }

    /**
     * @param  TwigEnvironment  $env
     * @param  array|Collection  $items
     * @return mixed
     */
    public function first(TwigEnvironment $env, $items)
    {
        if ($items instanceof Collection) {
            return $items->first();
        }

        return twig_first($env, $items);
    }

    /**
     * @param  TwigEnvironment  $env
     * @param  array|Collection  $items
     * @return mixed
     */
    public function last(TwigEnvironment $env, $items)
    {
        if ($items instanceof Collection) {
            return $items->last();
        }

        return twig_last($env, $items);
    }

    /**
     * @param  array|Collection $items
     * @param  string  $attribute
     * @return mixed
     */
    public function map($items, $attribute)
    {
        if (is_array($items)) {
            return array_map(function ($item) use ($attribute) {
                return $item[$attribute];
            }, array_filter($items, function ($item) use ($attribute) {
                return isset($item[$attribute]);
            }));
        } elseif ($items instanceof Collection) {
            return $items->map->{$attribute};
        }

        return [];
    }

    /**
     * @param  array|Collection $items
     * @return mixed
     */
    public function reverse($items)
    {
        if ($items instanceof Collection) {
            return $items->reverse();
        }

        return array_reverse($items);
    }

    /**
     * @param  TwigEnvironment  $env
     * @param  mixed $items
     * @return integer
     */
    public function length(TwigEnvironment $env, $items)
    {
        if ($items instanceof Collection) {
            return $items->count();
        }

        return twig_length_filter($env, $items);
    }

    /**
     * @param  mixed $items
     * @param  string $attribute
     * @return mixed
     * @throws \Twig_Error_Runtime
     */
    public function sort($items, $attribute = null)
    {
        if ($items instanceof Collection) {
            return $items->sortBy($attribute);
        }

        return twig_sort_filter($items);
    }

    /**
     * @param  mixed $items
     * @param  string $attribute
     * @return mixed
     * @throws \Twig_Error_Runtime
     */
    public function sortDesc($items, $attribute = null)
    {
        if ($items instanceof Collection) {
            return $items->sortByDesc($attribute);
        }

        return $this->reverse($this->sort($items));
    }

    /**
     * @param  array|Collection $items
     * @param  string  $attribute
     * @return mixed
     */
    public function unique($items, $attribute = null)
    {
        if ($items instanceof Collection) {
            return $items->unique($attribute);
        }

        return array_unique($items);
    }
}
