<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 17.01.19
 * Time: 16:12
 */

namespace Sf4\Api\RequestHandler;

use Doctrine\ORM\EntityManagerInterface;
use Sf4\Api\Repository\RepositoryFactory;
use Sf4\Api\Services\CacheAdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

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

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void;

    /**
     * @return TranslatorInterface
     */
    public function getTranslator(): TranslatorInterface;

    /**
     * @param TranslatorInterface $translator
     */
    public function setTranslator(TranslatorInterface $translator): void;

    /**
     * @return RepositoryFactory
     */
    public function getRepositoryFactory(): RepositoryFactory;

    /**
     * @param RepositoryFactory $repositoryFactory
     */
    public function setRepositoryFactory(RepositoryFactory $repositoryFactory): void;

    /**
     * @return array
     */
    public function getAvailableRoutes(): array;

    /**
     * @param array $availableRoutes
     */
    public function setAvailableRoutes(array $availableRoutes);

    /**
     * @return array|null
     */
    public function getSites(): ?array;

    /**
     * @param array|null $sites
     */
    public function setSites(?array $sites): void;

    /**
     * @return CacheAdapterInterface
     */
    public function getCacheAdapter(): CacheAdapterInterface;

    /**
     * @param CacheAdapterInterface $cacheAdapter
     */
    public function setCacheAdapter(CacheAdapterInterface $cacheAdapter): void;
}
