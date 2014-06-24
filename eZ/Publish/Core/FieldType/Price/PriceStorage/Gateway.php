<?php
/**
 * File containing the abstract Gateway class
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\PriceStorage;

use eZ\Publish\Core\FieldType\StorageGateway;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;
use eZ\Publish\SPI\Persistence\Content\Field;

/**
 *
 */
abstract class Gateway extends StorageGateway
{
    /**
     * Stores a price based on the given field data
     *
     * @param VersionInfo $versionInfo
     * @param Field $field
     *
     * @return boolean
     */
    abstract public function storeFieldData( VersionInfo $versionInfo, Field $field );

    /**
     * Get the price data, if there is a price for the given field
     *
     * @param Field $field
     *
     * @return void
     */
    abstract public function getFieldData( Field $field );

    /**
     * Deletes external data for $fieldId in $versionNo
     *
     * @param mixed $fieldId
     * @param mixed $versionNo
     *
     * @return void
     */
    abstract public function deleteFieldData( $versionNo, $fieldId );
}
