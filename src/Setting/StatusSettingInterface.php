<?php
/**
 * Created by PhpStorm.
 * User: siim
 * Date: 24.01.19
 * Time: 18:21
 */

namespace Sf4\Api\Setting;

interface StatusSettingInterface
{
    const ACTIVE = 1;
    const INACTIVE = 0;
    const ARCHIVED = 3;
    const PENDING = 4;
}
