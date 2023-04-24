<?php
declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetCompanyPrices
{
    #[Assert\NotBlank]
    #[Validator\ValidSymbol]
    private string $symbol;

    #[Assert\NotBlank]
    #[Assert\Email(message: "company_prices.email",)]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\Date(message: "company_prices.start_date.invalid")]
    #[Assert\LessThanOrEqual(propertyPath: "endDate", message: "company_prices.start_date.greater_than_end_date")]
    #[Assert\LessThanOrEqual("today", message: "company_prices.start_date.greater_than_current_date")]
    private string $startDate;

    #[Assert\NotBlank]
    #[Assert\Date(message: "company_prices.end_date.invalid")]
    #[Assert\GreaterThanOrEqual(propertyPath: "startDate", message: "company_prices.end_date.less_than_start_date")]
    #[Assert\LessThanOrEqual("today", message: "company_prices.end_date.greater_than_current_date")]
    private string $endDate;

    /**
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate(): string
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public static function createFromRequest(Request $request): static
    {
        $object = new static();
        $object->setEmail($request->request->get('email', ''));
        $object->setSymbol($request->request->get('symbol', ''));
        $object->setStartDate($request->request->get('startDate', ''));
        $object->setEndDate($request->request->get('endDate', ''));

        return $object;
    }

    public function validate(ValidatorInterface $validator): ConstraintViolationListInterface
    {
        return $validator->validate($this);
    }
}