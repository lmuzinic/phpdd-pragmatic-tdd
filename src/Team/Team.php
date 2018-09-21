<?php
declare(strict_types=1);


namespace BallGame\Team;


use BallGame\Exception\BadTeamNameException;

class Team
{
    /**
     * @var string
     */
    private $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(string $name)
    {
        if (strlen($name) === 0) {
            throw new BadTeamNameException();
        }

        return new self($name);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
