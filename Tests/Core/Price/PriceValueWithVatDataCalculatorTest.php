<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Tests\Core\Price;

use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
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

        $priceWithVat = $this->calculator->getValueWithVatData(
            $price,
            $vatRate
        );

        self::assertEquals( true, $priceWithVat->isVatIncluded );
        self::assertEquals( 120.6, $priceWithVat->price );
        self::assertEquals( 120.6, $priceWithVat->priceIncludingVat );
        self::assertEquals( 100, $priceWithVat->priceExcludingVat );
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

        self::assertEquals( false, $priceWithVat->isVatIncluded );
        self::assertEquals( 100, $priceWithVat->price );
        self::assertEquals( 120.6, $priceWithVat->priceIncludingVat );
        self::assertEquals( 100, $priceWithVat->priceExcludingVat );
    }
}
