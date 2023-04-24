<?php

namespace App\Repository\Implementation\Csv;

use App\Entity\Symbol;
use App\Repository\Interface\SymbolRepositoryInterface;

class SymbolRepository implements SymbolRepositoryInterface
{
    public function __construct(
        private readonly string $symbolsFilePath
    ) {
    }

    public function findBySymbol(string $symbol): ?Symbol
    {
        $symbol = strtoupper($symbol);
        if (($fp = fopen($this->symbolsFilePath, "r")) !== FALSE) {
            while (($line = fgetcsv($fp)) !== FALSE) {
                if ($symbol === strtoupper($line[1])) {
                    return new Symbol($line[0], $symbol);
                }
            }

            fclose($fp);
        }

        return null;
    }
}