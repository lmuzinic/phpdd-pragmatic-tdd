<?php
declare(strict_types=1);


namespace BallGame\Domain;


class GetTheBallRolling
{
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name)
    {
        return new self($name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBinaryGap(int $int)
    {
        $binary = decbin($int);

        $counting = false;
        $gap = 0;
        for ($i = 0; $i < strlen($binary); $i += 1) {
            if ($counting == true && $binary[$i] == 1) {
                $counting = false;
                continue;
            }

            if ($counting == false && $binary[$i] == 1) {
                $counting = true;
                continue;
            }

            if ($counting && $binary[$i] == 0) {
                $gap += 1;
            }
        }

        return $gap;
    }

    public function getOddOccurrences(array $input)
    {
        $countedInput = [];
        foreach ($input as $item) {
            if (!isset($countedInput[$item])) {
                $countedInput[$item] = 1;
            } else {
                $countedInput[$item] += 1;
            }
        }

        $flippedInput = array_flip($countedInput);

        return $flippedInput[1];
    }
}
