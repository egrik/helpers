<?php

namespace Garlic\Helpers;

use Tightenco\Collect\Support\Arr;

/**
 * Class ArrayHelper
 */
class ArrayHelper extends Arr
{
    /**
     * @param array $array
     * @param array $mapKeys
     *
     * @return array
     */
    public static function mapByKeys(array $array, array $mapKeys): array
    {
        $result = [];
        foreach ($mapKeys as $index => $key) {
            if (is_numeric($index)) {
                $index = $key;
            }
            if (isset($array[$index])) {
                $result[$key] = $array[$index];
            }
        }

        return $result;
    }

    /**
     * @param array $array
     * @param $key
     *
     * @return array
     */
    public static function groupBy(array $array, $key): array
    {
        if (!is_string($key) && !is_numeric($key) && !is_callable($key)) {
            throw new \InvalidArgumentException('The key should be a string, a number or a function');
        }

        $isFunction = !is_string($key) && is_callable($key);
        $grouped = [];
        foreach ($array as $value) {
            $groupKey = null;
            if ($isFunction) {
                $groupKey = $key($value);
            } elseif (is_object($value)) {
                $groupKey = $value->{$key};
            } else {
                $groupKey = $value[$key];
            }
            $grouped[$groupKey][] = $value;
        }

        if (func_num_args() > 2) {
            $args = func_get_args();
            foreach ($grouped as $groupKey => $value) {
                $grouped[$groupKey] = self::groupBy($value, ...array_slice($args, 2, func_num_args()));
            }
        }

        return $grouped;
    }

    /**
     * @param array $array
     * @param $item
     *
     * @return bool
     */
    public static function isLast(array $array, $item): bool
    {
        return static::last($array) === $item;
    }

    /**
     * @param array $array
     * @param $item
     *
     * @return bool
     */
    public static function isFirst(array $array, $item): bool
    {
        return static::first($array) === $item;
    }

    /**
     * @param array $array
     * @param $values
     *
     * @return array
     */
    public static function onlyValues(array $array, $values): array
    {
        return array_intersect($array, (array)$values);
    }

    /**
     * @param array $array
     * @param $values
     *
     * @return array
     */
    public static function exceptValues(array $array, $values)
    {
        return array_diff($array, (array)$values);
    }

    /**
     * @param array $array
     * @param null $parentKey
     *
     * @return array
     */
    public static function flattenWithPath(array $array, $parentKey = null): array
    {
        $merge = $result = [];
        foreach ($array as $key => $value) {
            $ikey = implode('.', self::removeNull([$parentKey, $key]));
            if (is_array($value)) {
                $merge[] = static::flattenWithPath($value, $ikey);
            } else {
                $result[$ikey] = $value;
            }
        }

        if (!empty($merge)) {
            $merge[] = $result;
            $result = array_merge(...$merge);
        }

        return $result;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public static function removeNull(array $array): array
    {
        return array_filter($array, static function ($item) {
            return $item !== null;
        });
    }
}
