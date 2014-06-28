<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\Gateway;

use EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\Gateway;
use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use eZ\Publish\Core\Base\Exceptions\NotFoundException;
use PDO;

class DoctrineDatabase extends Gateway
{
    /**
     * Database handler
     *
     * @var \eZ\Publish\Core\Persistence\Database\DatabaseHandler
     */
    protected $handler;

    /**
     * Construct from database handler
     *
     * @param \eZ\Publish\Core\Persistence\Database\DatabaseHandler $handler
     */
    public function __construct( DatabaseHandler $handler )
    {
        $this->handler = $handler;
    }

    /**
     * Returns an array with data associated to a VatRate
     *
     * @throws \eZ\Publish\Core\Base\Exceptions\NotFoundException if VatRate is not found.
     *
     * @param mixed $fieldId
     * @param int $versionNo
     *
     * @return array
     */
    public function getVatRateData( $fieldId, $versionNo )
    {
    }
}