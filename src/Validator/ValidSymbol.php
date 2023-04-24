<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidSymbol extends Constraint
{
    public string $message = 'company_prices.symbol';

    public string $mode = 'strict';
}
