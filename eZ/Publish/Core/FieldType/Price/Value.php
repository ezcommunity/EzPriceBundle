<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * The price, that includes or not VAT, depending on {@link $isVatIncluded}
     * @var float
     */
    public $price;

    /**
     * The id of the vat rate
     * @var int
     */
    public $vatRateId;

    /**
     * If VAT is, or not, included in $price {@link $isVatincluded}
     * @var bool
     */
    public $isVatIncluded = true;

    /**
     * @param float|array $price Either the price as a float, or an array of properties (price, isVatIncluded)
     * @param int $vatRateId
     * @param bool $isVatIncluded
     */
    public function __construct( $price = null, $vatRateId = null, $isVatIncluded = true )
    {
        if ( is_array( $price ) )
        {
            parent::__construct( $price );
        }
        else
        {
            $this->price = $price;
            $this->vatRateId = $vatRateId;
            $this->isVatIncluded = $isVatIncluded;
        }
    }

    public function __toString()
    {
        return (string)$this->price;
    }
}
