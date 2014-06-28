<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price;

abstract class Gateway
{
    /**
     * Returns an array with basic tag data
     *
     * @param mixed $fieldId
     * @param int $versionNo
     *
     * @return array
     */
    abstract public function getVatRateData( $fieldId, $versionNo );
}