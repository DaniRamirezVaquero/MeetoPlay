<?php

    require_once "library/Connection.php";

    class eventRequirement {

        public int $eventRequirementId;
        public ?string $maxRank;
        public ?string $minRank;
        public ?int $minAge;
        public ?int $maxAge;


        public function __construct(?string $maxRank, ?string $minRank, ?int $minAge, ?int $maxAge)
        {
            $this->maxRank = $maxRank;
            $this->minRank = $minRank;
            $this->minAge = $minAge;
            $this->maxAge = $maxAge;
        }
    }