<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\SPI\Persistence\Price;

interface VatHandler
{
    /**
     * Loads the VAT rate for $fieldId in $versionNo
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException If the specified vat is not found
     *
     * @param mixed $fieldId
     * @param int $versionNo
     *
     * @return \EzSystems\EzPriceBundle\API\Price\Values\VatRate
     */
    public function load( $fieldId, $versionNo );
}
