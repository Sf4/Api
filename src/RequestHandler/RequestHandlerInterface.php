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
}
