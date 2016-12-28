<?php

declare(strict_types=1);

namespace Smochin\HowOld\ValueObject;

class Face
{
    const MALE_GENDER = 'Male';
    const FEMALE_GENDER = 'Female';

    private $gender;
    private $age;

    /**
     * @param string $gender
     * @param int    $age
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(string $gender, int $age)
    {
        if (!in_array($gender, [self::MALE_GENDER, self::FEMALE_GENDER])) {
            throw new \InvalidArgumentException('Invalid gender');
        }

        if (!filter_var($age, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 130]])) {
            throw new \InvalidArgumentException('Invalid age');
        }

        $this->gender = $gender;
        $this->age = $age;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function isMale(): bool
    {
        return $this->gender == self::MALE_GENDER;
    }

    public function isFemale(): bool
    {
        return $this->gender == self::FEMALE_GENDER;
    }
}
