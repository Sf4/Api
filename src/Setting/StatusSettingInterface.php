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
    public const ACTIVE = 1;
    public const INACTIVE = 0;
    public const ARCHIVED = 3;
    public const PENDING = 4;
}
