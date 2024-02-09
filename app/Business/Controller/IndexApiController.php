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

namespace App\Business\Controller;

use App\Common\Controller\ApiController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Swow\Psr7\Message\ResponsePlusInterface;

#[Controller(server: 'http')]
class IndexApiController extends ApiController
{
    #[GetMapping(path: '/')]
    public function index(): ResponsePlusInterface
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        return $this->response->success([
            'user' => $user,
            'method' => $method,
            'message' => 'Hello LixWorth.',
        ]);
    }
}
