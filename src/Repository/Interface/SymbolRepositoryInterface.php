<?php

namespace App\Repository\Interface;

use App\Entity\Symbol;

interface SymbolRepositoryInterface
{
    public function findBySymbol(string $symbol): ?Symbol;
}
