<?php

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @param string $type
 * @return int
 * @throws ContainerExceptionInterface
 * @throws NotFoundExceptionInterface
 */
function m_per_page(string $type = 'default'): int
{
    if (session()->has($type)) {
        return session()->get($type);
    }

    return config('dashboard.per_page');
}

/**
 * @param string $key
 * @return string
 */
function m_key_to_label(string $key): string
{
    return str_replace(' id', '', str_replace('_', ' ', ucfirst($key)));
}





