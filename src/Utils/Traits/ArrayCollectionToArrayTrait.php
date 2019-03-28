<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 7.02.19
 * Time: 8:22
 */

namespace Sf4\Api\Utils\Traits;

use Doctrine\Common\Collections\ArrayCollection;

trait ArrayCollectionToArrayTrait
{
    protected function arrayCollectionToArray(ArrayCollection $items): array
    {
        $data = [];
        foreach ($items as $item) {
            $data[] = $item->toArray();
        }
        return $data;
    }
}
