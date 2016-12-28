<?php

declare(strict_types=1);

namespace Smochin\HowOld\Factory;

use Smochin\HowOld\ValueObject\Face;

class FaceFactory
{
    /**
     * @param string $gender
     * @param int    $age
     *
     * @return Face
     */
    public static function create(string $gender, int $age): Face
    {
        return new Face($gender, $age);
    }
}
