<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class TaxScheme implements XmlSerializable
{
    private $id;
    private $taxTypeCode;
    private $name;
    private $attributes;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return TaxScheme
     */
    public function setId(string $id): TaxScheme
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTaxTypeCode(): ?string
    {
        return $this->taxTypeCode;
    }

    /**
     * @param string $taxTypeCode
     * @return TaxScheme
     */
    public function setTaxTypeCode(?string $taxTypeCode)
    {
        $this->taxTypeCode = $taxTypeCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TaxScheme
     */
    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return TaxScheme
     */
    public function setAttributes(?array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function xmlSerialize(Writer $writer)
    {

        if($this->getAttributes()) {
            $writer->write([
                'name' => Schema::CBC . 'ID',
                'value' => $this->getId(),
                'attributes' => $this->getAttributes(),
            ]);
        } else {
            $writer->write([
                Schema::CBC . 'ID' => $this->id
            ]);
        }

        if ($this->taxTypeCode !== null) {
            $writer->write([
                Schema::CBC . 'TaxTypeCode' => $this->taxTypeCode
            ]);
        }
        if ($this->name !== null) {
            $writer->write([
                Schema::CBC . 'Name' => $this->name
            ]);
        }
    }
}
