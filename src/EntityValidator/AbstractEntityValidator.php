<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 10.02.19
 * Time: 16:55
 */

namespace Sf4\Api\EntityValidator;

use Sf4\Api\Entity\EntityInterface;
use Sf4\Api\Notification\NotificationInterface;
use Sf4\Api\Notification\Traits\ConvertViolationsToErrorMessage;
use Sf4\Api\Utils\Traits\TranslatorTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractEntityValidator
{
    use TranslatorTrait;
    use ConvertViolationsToErrorMessage;

    public const VALUE = 'value';
    public const CONSTRAINTS = 'constraints';
    public const MIN = 'min';
    public const PATTERN = 'pattern';

    public const OPTION_MESSAGE = 'message';
    public const OPTION_MIN_MESSAGE = 'minMessage';

    /*
     * \p{L} - single character
     * \p{Ll} - a lowercase letter
     * \p{Lu} - an uppercase letter
     * \p{Zs} - any kind of space character
     * \p{N} -  any kind of numeric character
     * \X - line break characters,
     * \p{P} - any kind of punctuation character
     */
    public const NAME_REGEX = '/^(\p{Lu})([\p{L}\p{Zs}-]+)(\p{Ll})$/um';

    /**
     * @param EntityInterface $entity
     * @return array
     */
    abstract protected function getValidationRules(EntityInterface $entity): array;

    /**
     * @param EntityInterface $entity
     * @param ValidatorInterface $validator
     * @param NotificationInterface $notification
     */
    public function validate(
        EntityInterface $entity,
        ValidatorInterface $validator,
        NotificationInterface $notification
    ): void {
        $rules = $this->getValidationRules($entity);
        foreach ($rules as $fieldName => $rule) {
            $this->validateField($validator, $notification, $fieldName, $rule);
        }
    }

    /**
     * @param ValidatorInterface $validator
     * @param NotificationInterface $notification
     * @param string $fieldName
     * @param array $rule
     */
    protected function validateField(
        ValidatorInterface $validator,
        NotificationInterface $notification,
        string $fieldName,
        array $rule
    ): void {
        $this->convertViolationsToErrormessage(
            $validator->validate(
                $rule[static::VALUE],
                $rule[static::CONSTRAINTS]
            ),
            $notification,
            $fieldName
        );
    }
}
