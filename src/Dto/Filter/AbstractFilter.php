<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 27.01.19
 * Time: 16:59
 */

namespace Sf4\Api\Dto\Filter;

use Sf4\Api\Dto\AbstractDto;

abstract class AbstractFilter extends AbstractDto implements FilterInterface
{
    public function populate(array $data): void
    {
        $newData = [];
        foreach($data as $key => $value) {
            if(isset($value->type) && isset($value->value)) {
                $filterItem = new BaseFilterItem();
                $filterItem->setType($value->type);
                $filterItem->setValue($value->value);
                $newData[$key] = $filterItem;
            }
        }
        parent::populate($newData);
    }
}
