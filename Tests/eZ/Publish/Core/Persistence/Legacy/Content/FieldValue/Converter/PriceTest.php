<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Tests\eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter;

use eZ\Publish\SPI\Persistence\Content\FieldValue;
use eZ\Publish\Core\Persistence\Legacy\Content\StorageFieldValue;
use EzSystems\EzPriceBundle\eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\Price as PriceConverter;
use PHPUnit_Framework_TestCase;
use DOMDocument;

/**
 * Test case for Price converter in Legacy storage
 *
 * @group fieldType
 * @group ezprice
 */
class PriceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \EzSystems\EzPriceBundle\eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\Price
     */
    protected $converter;

    protected function setUp()
    {
        parent::setUp();
        $this->converter = new PriceConverter;
    }

    /**
     * @covers \eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\Price::toStorageValue
     */
    public function testToStorageValue()
    {
        $price = 3.1415;
        $vatRateId = 1;

        $fieldValue = new FieldValue(
            array( 'data' => array( 'price' => $price, 'vatRateId' => $vatRateId, 'isVatIncluded' => false ) )
        );

        $storageFieldValue = new StorageFieldValue;

        $this->converter->toStorageValue( $fieldValue, $storageFieldValue );

        self::assertEquals( $price, $storageFieldValue->dataFloat );
        self::assertEquals( "1,2", $storageFieldValue->dataText );
    }

    /**
     * @covers \eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\Price::toFieldValue
     */
    public function testToFieldValue()
    {
        $price = 3.1415;
        $vatRateId = 1;

        $storageFieldValue = new StorageFieldValue(
            array(
                'dataFloat' => $price,
                'dataText' => "$vatRateId,2"
            )
        );

        $fieldValue = new FieldValue;

        $this->converter->toFieldValue( $storageFieldValue, $fieldValue );

        self::assertEquals( $price, $fieldValue->data['price'] );
        self::assertEquals( $vatRateId, $fieldValue->data['vatRateId'] );
        self::assertEquals( false, $fieldValue->data['isVatIncluded'] );
    }
}
