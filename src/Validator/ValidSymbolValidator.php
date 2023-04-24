<?php

namespace App\Validator;

use App\Repository\Interface\SymbolRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidSymbolValidator extends ConstraintValidator
{
    public function __construct(
        private readonly SymbolRepositoryInterface $symbolRepository
    ) {
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof ValidSymbol) {
            throw new UnexpectedTypeException($constraint, ValidSymbol::class);
        }

        if ('' === $value || null === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        $symbol = $this->symbolRepository->findBySymbol($value);
        if (null === $symbol) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
