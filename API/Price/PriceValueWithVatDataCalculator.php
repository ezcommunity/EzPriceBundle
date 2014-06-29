<?php
/**
 * This file is part of the eZ Publish Legacy package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\EzPriceBundle\API\Price;

use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;

/**
 * Creates PriceWithVatData objects based on Price Value + VatRate
 */
interface PriceValueWithVatDataCalculator
{
    /**
     * @param array $value
     * @param VatRate $vatRate
     *
     * @return \EzSystems\EzPriceBundle\API\Price\Values\PriceWithVatData
     */
    public function getValueWithVatData( PriceValue $value, VatRate $vatRate );
}
