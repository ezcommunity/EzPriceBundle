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
