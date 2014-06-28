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
        $vatId = $this->findVatId( $fieldId, $versionNo );
        return $this->getVatRateDataById( $vatId );
    }

    /**
     * Gets the id of the vat rate associated with Field id $fieldId and version number $versionNo
     *
     * @param $fieldId
     * @param $versionNo
     *
     * @return int;
     */
    private function findVatId( $fieldId, $versionNo )
    {
        $query = $this->handler->createSelectQuery();
        $query
            ->select( 'data_text' )
            ->from( $this->handler->quoteTable( 'ezcontentobject_attribute' ) )
            ->where(
                $query->expr->lAnd(
                    $query->expr->eq(
                        $this->handler->quoteColumn( 'id' ),
                        $query->bindValue( $fieldId, null, PDO::PARAM_INT )
                    ),
                    $query->expr->eq(
                        $this->handler->quoteColumn( 'version' ),
                        $query->bindValue( $versionNo, null, PDO::PARAM_INT )
                    )
                )
            );

        $statement = $query->prepare();
        $statement->execute();

        if ( $row = $statement->fetch( PDO::FETCH_ASSOC ) )
        {
            $rowVatData = explode( ',', $row['data_text'] );
            return (int)$rowVatData[1];
        }
    }

    /**
     * Queries database to get data of the Vat Rate
     *
     * @param int $vatId
     *
     * @return array
     */
    private function getVatRateDataById( $vatId )
    {
        $query = $this->handler->createSelectQuery();
        $query
            ->select( array( 'name', 'percentage' ) )
            ->from( $this->handler->quoteTable( 'ezvattype' ) )
            ->where(
                $query->expr->eq(
                    $this->handler->quoteColumn( 'id' ),
                    $query->bindValue( $vatId, null, PDO::PARAM_INT )
                )
            );

        $statement = $query->prepare();
        $statement->execute();

        return $statement->fetch();
    }
}