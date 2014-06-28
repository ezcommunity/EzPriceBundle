<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price;

use EzSystems\EzPriceBundle\SPI\Persistence\Price\VatHandler as VatHandlerInterface;
use EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\Gateway;
use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
use eZ\Publish\API\Repository\Exceptions\NotImplementedException;

class VatHandler implements VatHandlerInterface
{
    /**
     * @var \EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\Gateway
     */
    protected $gateway;

    /**
     * @param \EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\Gateway $gateway
     */
    public function __construct( Gateway $gateway )
    {
        $this->gateway = $gateway;
    }

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
    public function load( $fieldId, $versionNo )
    {
        $vatRateData = $this->gateway->getVatRateData( $fieldId, $versionNo );
        return new VatRate( $vatRateData );
    }
}
