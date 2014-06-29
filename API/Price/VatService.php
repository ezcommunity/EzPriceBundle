<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\API\Price;

use EzSystems\EzPriceBundle\API\Price\Values\VatRate;

interface VatService
{
    /**
     * Loads the VAT rate for $fieldId in $versionNo
     * @param mixed $fieldId
     * @param int $versionNo
     * @return \EzSystems\EzPriceBundle\API\Price\Values\VatRate
     */
    public function loadVatRate( $fieldId, $versionNo );
}
