<?php

namespace NumNum\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class AdditionalDocumentReference implements XmlSerializable
{
    private $id;
    private $documentType;
    private $attachment;
    private $UUID;

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return AdditionalDocumentReference
     */
    public function setId(string $id): AdditionalDocumentReference
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentType(): ?string
    {
        return $this->documentType;
    }

    /**
     * @param string $documentType
     * @return AdditionalDocumentReference
     */
    public function setDocumentType(string $documentType): AdditionalDocumentReference
    {
        $this->documentType = $documentType;
        return $this;
    }

    /**
     * @return Attachment
     */
    public function getAttachment(): ?Attachment
    {
        return $this->attachment;
    }

    /**
     * @param Attachment $attachment
     * @return AdditionalDocumentReference
     */
    public function setAttachment(Attachment $attachment): AdditionalDocumentReference
    {
        $this->attachment = $attachment;
        return $this;
    }

    /**
     * @return UUID
     */
    public function getUUID(): ?AdditionalDocumentReference
    {
        return $this->attachment;
    }

    /**
     * @param String $UUID
     * @return AdditionalDocumentReference
     */
    public function setUUID(String $UUID): AdditionalDocumentReference
    {
        $this->UUID = $UUID;
        return $this;
    }

    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([ Schema::CBC . 'ID' => $this->id ]);
        if ($this->documentType !== null) {
            $writer->write([
                Schema::CAC . 'DocumentType' => $this->documentType
            ]);
        }
        if($this->UUID !== null) {
            $writer->write([
                Schema::CBC . 'UUID'=> $this->UUID
            ]);
        }
        if($this->attachment != null) {
            $writer->write([ Schema::CAC . 'Attachment' => $this->attachment ]);
        } 
    }
}
