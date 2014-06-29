<?php
/**
 * This file is part of the eZ Publish Legacy package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributd with this source code.
 * @version //autogentag//
 */
namespace EzSystems\EzPriceBundle\Core\Price;

use EzSystems\EzPriceBundle\API\Price\Values\PriceWithVatData;
use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;
use EzSystems\EzPriceBundle\API\Price\PriceValueWithVatDataCalculator as PriceValueWithVatDataCalculatorInterface;

/**
 * Creates PriceWithVatData objects based on Price Value + VatRate
 */
class PriceValueWithVatDataCalculator implements PriceValueWithVatDataCalculatorInterface
{
    public function getValueWithVatData( PriceValue $value, VatRate $vatRate )
    {
        $properties = array(
            'price' => $value->price,
            'isVatIncluded' => $value->isVatIncluded
        );

        $vatRatio = 1 + ( $vatRate->percentage / 100 );
        if ( $value->isVatIncluded )
        {
            $properties['priceIncludingVat'] = $value->price;
            $properties['priceExcludingVat'] = $value->price / $vatRatio;
        }
        else
        {
            $properties['priceExcludingVat'] = $value->price;
            $properties['priceIncludingVat'] = $value->price * $vatRatio;
        }

        return new PriceWithVatData( $properties );
    }
}
