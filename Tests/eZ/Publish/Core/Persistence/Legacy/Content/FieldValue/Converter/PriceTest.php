<?php
/**
 * File containing the AuthorTest class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
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
        $fieldValue = new FieldValue;
        $fieldValue->data = 3.1415;

        $storageFieldValue = new StorageFieldValue;

        $this->converter->toStorageValue( $fieldValue, $storageFieldValue );

        self::assertEquals( $fieldValue->data, $storageFieldValue->dataFloat );
    }

    /**
     * @covers \eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\Price::toFieldValue
     */
    public function testToFieldValue()
    {
        $storageFieldValue = new StorageFieldValue;
        $storageFieldValue->dataFloat = 3.1415;

        $fieldValue = new FieldValue;

        $this->converter->toFieldValue( $storageFieldValue, $fieldValue );

        self::assertEquals( $storageFieldValue->dataFloat, $fieldValue->data );
    }
}
