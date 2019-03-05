<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 16:12
 */

namespace Sf4\Api\RequestHandler;

use Sf4\Api\Request\RequestTraitInterface;
use Sf4\Api\RequestHandler\Traits\AvailableRoutesTraitInterface;
use Sf4\Api\RequestHandler\Traits\CacheAdapterTraitInterface;
use Sf4\Api\RequestHandler\Traits\EventDispatcherTraitInterface;
use Sf4\Api\RequestHandler\Traits\RepositoryFactoryTraitInterface;
use Sf4\Api\RequestHandler\Traits\SitesTraitInterface;
use Sf4\Api\Utils\Traits\EntityManagerTraitInterface;
use Sf4\Api\Utils\Traits\TranslatorTraitInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface RequestHandlerInterface extends
    CacheAdapterTraitInterface,
    SitesTraitInterface,
    RepositoryFactoryTraitInterface,
    AvailableRoutesTraitInterface,
    EventDispatcherTraitInterface,
    TranslatorTraitInterface,
    EntityManagerTraitInterface,
    RequestTraitInterface
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
