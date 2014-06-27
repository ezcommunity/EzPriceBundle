<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Tests;

use eZ\Publish\Core\FieldType\Tests\FieldTypeTest;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Type as PriceType;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;

/**
 * @group fieldType
 * @group ezprice
 */
class PriceTest extends FieldTypeTest
{
    /**
     * Returns the field type under test.
     *
     * This method is used by all test cases to retrieve the field type under
     * test. Just create the FieldType instance using mocks from the provided
     * get*Mock() methods and/or custom get*Mock() implementations. You MUST
     * NOT take care for test case wide caching of the field type, just return
     * a new instance from this method!
     *
     * @return FieldType
     */
    protected function createFieldTypeUnderTest()
    {
        $fieldType = new PriceType();
        $fieldType->setTransformationProcessor( $this->getTransformationProcessorMock() );

        return $fieldType;
    }

    /**
     * Returns the validator configuration schema expected from the field type.
     *
     * @return array
     */
    protected function getValidatorConfigurationSchemaExpectation()
    {
        return array();
    }

    /**
     * Returns the settings schema expected from the field type.
     *
     * @return array
     */
    protected function getSettingsSchemaExpectation()
    {
        return array();
    }

    /**
     * Returns the empty value expected from the field type.
     *
     * @return PriceValue
     */
    protected function getEmptyValueExpectation()
    {
        return new PriceValue;
    }

    /**
     * Data provider for invalid input to acceptValue().
     *
     * Returns an array of data provider sets with 2 arguments: 1. The invalid
     * input to acceptValue(), 2. The expected exception type as a string. For
     * example:
     *
     * <code>
     *  return array(
     *      array(
     *          new \stdClass(),
     *          'eZ\\Publish\\Core\\Base\\Exceptions\\InvalidArgumentException',
     *      ),
     *      array(
     *          array(),
     *          'eZ\\Publish\\Core\\Base\\Exceptions\\InvalidArgumentException',
     *      ),
     *      // ...
     *  );
     * </code>
     *
     * @return array
     */
    public function provideInvalidInputForAcceptValue()
    {
        return array(
            array(
                array( 'price' => 'foo' ),
                'eZ\\Publish\\Core\\Base\\Exceptions\\InvalidArgumentException',
            ),
            array(
                new PriceValue( array( 'price' => 'foo' ) ),
                'eZ\\Publish\\Core\\Base\\Exceptions\\InvalidArgumentException',
            ),
            array(
                new PriceValue(
                    array( 'price' => 20, 'is_vat_included' => 'foo' )
                ),
                'eZ\\Publish\\Core\\Base\\Exceptions\\InvalidArgumentException',
            )
        );
    }


    /**
     * Data provider for valid input to acceptValue().
     *
     *
     * @return array
     */
    public function provideValidInputForAcceptValue()
    {
        return array(
            array(
                null,
                new PriceValue,
            ),
            array(
                array(
                    'price' => 42.23,
                    'is_vat_included' => false,
                    'vat_percentage' => 5.2
                ),
                new PriceValue(
                    array(
                        'price' => 42.23,
                        'is_vat_included' => false,
                        'vat_percentage' => 5.2
                    )
                ),
            ),
            array(
                array( 'price' => 23. ),
                new PriceValue(
                    array(
                        'price' => 23.,
                        'is_vat_included' => false
                    )
                )
            ),
            array(
                new PriceValue(
                    array( 'price' => 23.42 )
                ),
                new PriceValue(
                    array(
                        'price' => 23.42,
                        'is_vat_included' => false,
                        'vat_percentage' => 0
                    )
                ),
            ),
        );
    }

    /**
     * Provide input for the toHash() method
     *
     * @return array
     */
    public function provideInputForToHash()
    {
        return array(
            array(
                new PriceValue,
                null,
            ),
            array(
                new PriceValue(
                    array( 'price' => 23.42 )
                ),
                array(
                    'price' => 23.42,
                    'is_vat_included' => false,
                    'vat_percentage' => 0
                ),
            ),
            array(
                new PriceValue(
                    array(
                        'price' => 23.42,
                        'is_vat_included' => true
                    )
                ),
                array(
                    'price' => 23.42,
                    'is_vat_included' => true,
                    'vat_percentage' => 0
                ),
            ),
            array(
                new PriceValue(
                    array(
                        'price' => 23.42,
                        'is_vat_included' => true,
                        'vat_percentage' => 18.5
                    )
                ),
                array(
                    'price' => 23.42,
                    'is_vat_included' => true,
                    'vat_percentage' => 18.5
                ),
            ),
        );
    }

    /**
     * Provide input to fromHash() method
     *
     * Returns an array of data provider sets with 2 arguments: 1. The valid
     * input to fromHash(), 2. The expected return value from fromHash().
     * For example:
     *
     * <code>
     *  return array(
     *      array(
     *          null,
     *          null
     *      ),
     *      array(
     *          array(
     *              'path' => 'some/file/here',
     *              'fileName' => 'sindelfingen.jpg',
     *              'fileSize' => 2342,
     *              'downloadCount' => 0,
     *              'mimeType' => 'image/jpeg',
     *          ),
     *          new BinaryFileValue( array(
     *              'path' => 'some/file/here',
     *              'fileName' => 'sindelfingen.jpg',
     *              'fileSize' => 2342,
     *              'downloadCount' => 0,
     *              'mimeType' => 'image/jpeg',
     *          ) )
     *      ),
     *      // ...
     *  );
     * </code>
     *
     * @return array
     */
    public function provideInputForFromHash()
    {
        return array(
            array(
                null,
                new PriceValue,
            ),
            array(
                array( 'price' => 23.42 ),
                new PriceValue(
                    array(
                        'price' => 23.42
                    )
                ),
            ),
        );
    }

    protected function provideFieldTypeIdentifier()
    {
        return 'ezprice';
    }

    public function provideDataForGetName()
    {
        return array(
            array( $this->getEmptyValueExpectation(), "" ),
            array(
                new PriceValue(
                    array(
                        'price' => 23.42
                    )
                ),
                "23.42"
            ),
            array(
                new PriceValue(
                    array(
                        'price' => 23.42,
                        'is_vat_included' => true,
                        'vat_percentage' => 18
                    )
                ),
                "23.42"
            )
        );
    }

    /**
     * Provides data sets with validator configuration and/or field settings and
     * field value which are considered valid by the {@link validate()} method.
     *
     *
     * @return array
     */
    public function provideValidDataForValidate()
    {
        return array(
            array(
                array(),
                new PriceValue(
                    array(
                        'price' => 7.5
                    )
                ),
            ),
        );
    }
}
