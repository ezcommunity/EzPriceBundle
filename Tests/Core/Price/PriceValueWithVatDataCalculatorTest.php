<?php
/**
 * This file is part of the eZ Publish Legacy package
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributd with this source code.
 * @version //autogentag//
 */
namespace EzSystems\EzPriceBundle\Tests\Core\Price;

use EzSystems\EzPriceBundle\API\Price\Values\PriceWithVatData;
use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;
use EzSystems\EzPriceBundle\Core\Price\PriceValueWithVatDataCalculator;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;
use PHPUnit_Framework_TestCase;

/**
 * @covers \EzSystems\EzPriceBundle\Core\Price\PriceValueWithVatDataCalculator
 */
class PriceValueWithVatDataCalculatorTest extends PHPUnit_Framework_TestCase
{
    /** @var \EzSystems\EzPriceBundle\Core\Price\PriceValueWithVatDataCalculator */
    private $calculator;

    public function setUp()
    {
        $this->calculator = new PriceValueWithVatDataCalculator();
    }

    public function testVatDataVatExcluded()
    {
        $price = new PriceValue(
            array(
                'price' => 120.6,
                'isVatIncluded' => true
            )
        );

        $vatRate = new VatRate(
            array(
                'percentage' => 20.6,
                'name' => 'test'
            )
        );

        $priceWithVat = $this->calculator->getValueWithVatData( $price, $vatRate );

        self::assertEquals(
            new PriceWithVatData(
                array(
                    'isVatIncluded' => true,
                    'price' => 120.6,
                    'priceIncludingVat' => 120.6,
                    'priceExcludingVat' => 100
                )
            ),
            $priceWithVat
        );
    }

    public function testVatDataVatIncluded()
    {
        $price = new PriceValue(
            array(
                'price' => 100,
                'isVatIncluded' => false
            )
        );

        $vatRate = new VatRate(
            array(
                'percentage' => 20.6,
                'name' => 'test'
            )
        );

        $priceWithVat = $this->calculator->getValueWithVatData(
            $price,
            $vatRate
        );

        self::assertEquals(
            new PriceWithVatData(
                array(
                    'isVatIncluded' => false,
                    'price' => 100,
                    'priceIncludingVat' => 120.6,
                    'priceExcludingVat' => 100
                )
            ),
            $priceWithVat
        );
    }
}
