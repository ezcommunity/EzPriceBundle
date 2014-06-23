<?php

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * Base price
     *
     * @var float
     */
    public $price;

    /**
     * Is the VAT included with the price or not
     *
     * @var bool
     */
    public $is_vat_included = false;

    /**
     * Percentage associated with the VAT
     *
     * @var float
     */
    public $vat_percentage = 0;

    public function __toString()
    {
        return (string)$this->price;
    }
}