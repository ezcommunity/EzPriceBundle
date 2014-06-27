<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\SPI\Persistence\Content\FieldValue;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\Core\FieldType\Value as BaseValue;

class Type extends FieldType
{
    /**
     * Returns the field type identifier for this field type
     *
     * @return string
     */
    public function getFieldTypeIdentifier()
    {
        return 'ezprice';
    }

    /**
     * Returns the name of the given field value.
     *
     * It will be used to generate content name and url alias if current field is designated
     * to be used in the content name/urlAlias pattern.
     *
     * @param \eZ\Publish\SPI\FieldType\Value $value
     *
     * @return string
     */
    public function getName( SPIValue $value )
    {
        return (string)$value->price;
    }

    /**
     * Returns the fallback default value of field type when no such default
     * value is provided in the field definition in content types.
     *
     * @return \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value
     */
    public function getEmptyValue()
    {
        return new Value;
    }

    /**
     * Implements the core of {@see isEmptyValue()}.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function isEmptyValue( SPIValue $value )
    {
        return $value->price === null;
    }

    /**
     * Inspects given $inputValue and potentially converts it into a dedicated value object.
     *
     * @param int|float|\EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $inputValue
     *
     * @return \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value The potentially converted and structurally plausible value.
     * @todo define all the ways a price could be entered
     *
     */
    protected function createValueFromInput( $inputValue )
    {
        if ( is_int( $inputValue ) )
        {
            $inputValue = (float)$inputValue;
        }

        if ( is_float( $inputValue ) )
        {
            $inputValue = new Value( $inputValue );
        }

        return $inputValue;
    }

    /**
     * Throws an exception if value structure is not of expected format.
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException If the value does not match the expected structure.
     *
     * @param \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $value
     *
     * @return void
     */
    protected function checkValueStructure( BaseValue $value )
    {
        if ( !is_float( $value->price ) )
        {
            throw new InvalidArgumentType(
                '$value->price',
                'float',
                $value->price
            );
        }
    }

    /**
     * Returns information for FieldValue->$sortKey relevant to the field type.
     *
     * @param \eZ\Publish\Core\FieldType\Price\Value $value
     *
     * @return array
     */
    protected function getSortInfo( BaseValue $value )
    {
        $intPrice = (int)($value->price * 100.00);
        return $intPrice;
    }

    /**
     * Converts an $hash to the Value defined by the field type
     *
     * @param mixed $hash
     *
     * @return \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $value
     */
    public function fromHash( $hash )
    {
        if ( $hash === null )
        {
            return $this->getEmptyValue();
        }
        return new Value( $hash );
    }

    /**
     * Converts a $Value to a hash
     *
     * @param \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value $value
     *
     * @return mixed
     */
    public function toHash( SPIValue $value )
    {
        if ( $this->isEmptyValue( $value ) )
        {
            return null;
        }
        return (array)$value;
    }

    /**
     * Returns whether the field type is searchable
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return true;
    }

    /**
     * Converts a persistence $fieldValue to a Value
     *
     * This method builds a field type value from the $data and $externalData properties.
     *
     * @param \eZ\Publish\SPI\Persistence\Content\FieldValue $fieldValue
     *
     * @return \eZ\Publish\Core\FieldType\Price\Value
     */
    public function fromPersistenceValue( FieldValue $fieldValue )
    {
        if ( isset( $fieldValue->data['price'] ) && $fieldValue->data['price'] != null )
        {
            $isVatIncluded = isset( $fieldValue->data['is_vat_included'] ) ? (bool)$fieldValue->data['is_vat_included'] : true;
            return new Value( $fieldValue->data['price'], $isVatIncluded );
        }
    }
}
