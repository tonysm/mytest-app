<?php

function array_only(array $data, array $keys)
{
    $result = [];

    foreach ($data as $key => $val)
    {
        if (in_array($key, $keys))
            $result[$key] = $val;
    }

    foreach ($keys as $key_check)
    {
        if ( ! isset($result[$key_check]))
            $result[$key_check] = "";
    }

    return $result;
}