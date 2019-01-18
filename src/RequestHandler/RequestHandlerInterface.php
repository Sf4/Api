<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 16:12
 */

namespace Sf4\Api\RequestHandler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface RequestHandlerInterface
{

    /**
     * @param Request $request
     */
    public function handle(Request $request);

    /**
     * @return JsonResponse|null
     */
    public function getResponse(): ?JsonResponse;
}
