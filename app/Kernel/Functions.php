<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\AsyncQueue\JobInterface;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\Formatter\FormatterInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Redis\RedisFactory;
use Hyperf\Redis\RedisProxy;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

if (! function_exists('di')) {
    function di(?string $id = null): ContainerInterface
    {
        $container = ApplicationContext::getContainer();
        if ($id) {
            return $container->get($id);
        }

        return $container;
    }
}

if (! function_exists('format_throwable')) {
    function format_throwable(Throwable $throwable): string
    {
        return di()->get(FormatterInterface::class)->format($throwable);
    }
}

if (! function_exists('queue_push')) {
    function queue_push(JobInterface $job, int $delay = 0, string $key = 'default'): bool
    {
        $driver = di()->get(DriverFactory::class)->get($key);
        return $driver->push($job, $delay);
    }
}

if (! function_exists('logger')) {
    function logger(string $name = 'hyperf', string $group = 'default'): LoggerInterface
    {
        if ($group == 'stdout') {
            return di()->get(StdoutLoggerInterface::class);
        }
        return di()->get(LoggerFactory::class)->getLogger($name, $group);
    }
}

if (! function_exists('redis')) {
    function redis(string $name = 'default'): RedisProxy
    {
        return di()->get(RedisFactory::class)->get($name);
    }
}
