<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

use InvalidArgumentException;

class TaxTotal implements XmlSerializable
{
    private $taxAmount;
    private $taxSubTotals = [];
    private $roundingAmount;
    private $currency; // If not provided, will use default invoice currency

    /**
     * @return mixed
     */
    public function getTaxAmount(): ?float
    {
        return $this->taxAmount;
    }

    /**
     * @param mixed $taxAmount
     * @return TaxTotal
     */
    public function setTaxAmount(?float $taxAmount): TaxTotal
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    /**
     * @return array
     */
    public function getTaxSubTotals(): array
    {
        return $this->taxSubTotals;
    }

    /**
     * @param TaxSubTotal $taxSubTotal
     * @return TaxTotal
     */
    public function addTaxSubTotal(TaxSubTotal $taxSubTotal): TaxTotal
    {
        $this->taxSubTotals[] = $taxSubTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoundingAmount(): float
    {
        return $this->roundingAmount;
    }

    /**
     * @param mixed $roundingAmount
     * @return TaxTotal
     */
    public function setRoundingAmount(?float $amount): TaxTotal
    {
        $this->roundingAmount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): ?string
    {
        if(!$this->currency) {
            return Generator::$currencyID;
        }
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return TaxTotal
     */
    public function setCurrency(?string $currency): TaxTotal
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * The validate function that is called during xml writing to valid the data of the object.
     *
     * @throws InvalidArgumentException An error with information about required data that is missing to write the XML
     * @return void
     */
    public function validate()
    {
        if ($this->taxAmount === null) {
            throw new InvalidArgumentException('Missing taxtotal taxamount');
        }
    }

    /**
     * The xmlSerialize method is called during xml writing.
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer): void
    {
        $this->validate();

        $currencyID = $this->getCurrency();

        $writer->write([
            [
                'name' => Schema::CBC . 'TaxAmount',
                'value' => number_format($this->taxAmount, 2, '.', ''),
                'attributes' => [
                    'currencyID' => $currencyID
                ]
            ],
        ]);

        if($this->roundingAmount !== null && $this->roundingAmount !== '') {
            $writer->write([
                [
                    'name' => Schema::CBC . 'RoundingAmount',
                    'value' => number_format($this->roundingAmount, 2, '.', ''),
                    'attributes' => [
                        'currencyID' => $currencyID
                    ]
                ],
            ]);
        }

        foreach ($this->taxSubTotals as $taxSubTotal) {
            $writer->write([Schema::CAC . 'TaxSubtotal' => $taxSubTotal]);
        }
    }
}
