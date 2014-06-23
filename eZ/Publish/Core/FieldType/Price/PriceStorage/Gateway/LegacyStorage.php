<?php
/**
 * File containing the Price LegacyStorage Gateway
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version //autogentag//
 */

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;

use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use eZ\Publish\Core\FieldType\Url\UrlStorage\Gateway;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;
use eZ\Publish\SPI\Persistence\Content\Field;

/**
 * Price field type external storage gateway implementation using Zeta Database Component.
 */
class LegacyStorage extends Gateway
{
   /**
    * Connection
    *
    * @var mixed
    */
   protected $dbHandler;

   /**
    * Set database handler for this gateway
    *
    * @param mixed $dbHandler
    *
    * @return void
    * @throws \RuntimeException if $dbHandler is not an instance of
    *         {@link \eZ\Publish\Core\Persistence\Database\DatabaseHandler}
    */
   public function setConnection( $dbHandler )
   {
       if ( ! ( $dbHandler instanceof DatabaseHandler ) )
       {
           throw new \RuntimeException( "Invalid dbHandler passed" );
       }

       $this->dbHandler = $dbHandler;
   }

   /**
    * Returns the active connection
    *
    * @throws \RuntimeException if no connection has been set, yet.
    *
    * @return \eZ\Publish\Core\Persistence\Database\DatabaseHandler
    */
   protected function getConnection()
   {
       if ( $this->dbHandler === null )
       {
           throw new \RuntimeException( "Missing database connection." );
       }
       return $this->dbHandler;
   }

   /**
    * @see \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway
    */
   public function storeFieldData( VersionInfo $versionInfo, Field $field )
   {
   }

   /**
    * Gets the price for the given field
    *
    * @see \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway
    */
   public function getFieldData( Field $field )
   {
       $price = $this->fetchPrice( $field->id, $field->versionNo );
       $field->value->externalData = array( 'price' => $price );
   }

   /**
    * Deletes price data for field with $fieldId in $versionNo.
    *
    * @param mixed $fieldId
    * @param mixed $versionNo
    *
    * @return void
    */
   public function deleteFieldData( $fieldId, $versionNo )
   {
   }

    /**
     * Query database for getting the price associated to the fieldId and
     * versionNo
     *
     * @param int $fieldId
     * @param int $versionNo
     */
    private function fetchPrice( $fieldId, $versionNo )
    {
        $dbHandler = $this->getConnection();

        $selectQuery = $dbHandler->createSelectQuery();
        $selectQuery->select( "data_float" )
            ->from( $dbHandler->quoteTable( "ezcontentobject_attribute" ) )
            ->where(
                $selectQuery->expr->lAnd(
                    $selectQuery->expr->eq(
                        $dbHandler->quoteColumn( 'id' ),
                        $selectQuery->bindValue( $fieldId )
                    ),
                    $selectQuery->expr->eq(
                        $dbHandler->quoteColumn( 'version' ),
                        $selectQuery->bindValue( $versionNo )
                    )
                )
            );

        $statement = $selectQuery->prepare();
        $statement->execute();

        return $statement->fetchColumn();
    }
}
