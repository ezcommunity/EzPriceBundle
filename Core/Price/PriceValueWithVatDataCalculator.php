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
    /**
     * Returns an object adding the price with and without Vat applied
     *
     * @param \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $price
     * @param VatRate $vatRate
     *
     * @return \EzSystems\EzPriceBundle\API\Price\Values\PriceWithVatData
     */
    public function getValueWithVatData( PriceValue $price, VatRate $vatRate )
    {
        $priceWithVatInfo = array(
            'price' => $price->price,
            'isVatIncluded' => $price->isVatIncluded
        );

        $vatRatio = 1 + ( $vatRate->percentage / 100 );
        if ( $price->isVatIncluded )
        {
            $priceWithVatInfo['priceIncludingVat'] = $price->price;
            $priceWithVatInfo['priceExcludingVat'] = $price->price / $vatRatio;
        }
        else
        {
            $priceWithVatInfo['priceExcludingVat'] = $price->price;
            $priceWithVatInfo['priceIncludingVat'] = $price->price * $vatRatio;
        }

        $priceWithVatInfo['vatRate'] = $vatRate->percentage;

        return new PriceWithVatData( $priceWithVatInfo );
    }
}
