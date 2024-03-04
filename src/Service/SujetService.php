<?php
// src/Service/SujetService.php

namespace App\Service;

use App\Entity\Sujet;

class SujetService
{
    public function createNewSujet(): Sujet
    {
        return new Sujet();
    }
}