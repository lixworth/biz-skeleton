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

namespace App\Kernel\Listener;

use Hyperf\Collection\Arr;
use Hyperf\Database\Events\QueryExecuted;
use Hyperf\Event\Contract\ListenerInterface;

use function Hyperf\Support\env;

class DbQueryExecutedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            QueryExecuted::class,
        ];
    }

    public function process(object $event): void
    {
        if ($event instanceof QueryExecuted) {
            $sql = $event->sql;
            if (! Arr::isAssoc($event->bindings)) {
                $position = 0;
                foreach ($event->bindings as $value) {
                    $position = strpos($sql, '?', $position);
                    if ($position === false) {
                        break;
                    }
                    $value = "'{$value}'";
                    $sql = substr_replace($sql, $value, $position, 1);
                    $position += strlen($value);
                }
            }

            logger('sql')->info(sprintf('[%s:%s] %s', $event->connectionName, $event->time, $sql));

            if (env('LOGGER_DEBUG', 'dev') === 'dev') {
                logger('sql', 'stdout')->info(sprintf('[%s:%s] %s', $event->connectionName, $event->time, $sql));
            }
        }
    }
}
