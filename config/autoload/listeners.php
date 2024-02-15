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
use App\Kernel\Listener\DbQueryExecutedListener;
use Hyperf\AsyncQueue\Listener\QueueHandleListener;
use Hyperf\Command\Listener\FailToHandleListener;
use Hyperf\Coordinator\Listener\ResumeExitCoordinatorListener;
use Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler;

use function Hyperf\Support\env;

return [
    ErrorExceptionHandler::class,
    FailToHandleListener::class,
    env('APP_ENV', 'dev') == 'dev' ? DbQueryExecutedListener::class : null,
    QueueHandleListener::class,
    ResumeExitCoordinatorListener::class,
];
