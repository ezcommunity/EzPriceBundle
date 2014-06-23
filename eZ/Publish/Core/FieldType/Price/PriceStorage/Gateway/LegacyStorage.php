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
       $field->value->externalData = $this->fetchPrice( $field->id, $field->versionNo );
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
         $price = array();
         $dbHandler = $this->getConnection();

         $selectQuery = $dbHandler->createSelectQuery();
         $selectQuery->select( array( 'data_float', 'data_text' ) )
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
         $priceRow = $statement->fetch();

         // base price
         $price['price'] = $priceRow['data_float'];
         // get data_text and explode it
         $rowDataText = explode( ',', $priceRow['data_text'] );
         // vat type id is in the first position of the exploded data_text
         $price['vat_type'] = $rowDataText[0];
         // is_vat_included is in the second position. Convert to boolean here
         // depending on the value
         $price['is_vat_included'] = $rowDataText[1] == 1 ? true : false;

         return $price;
     }
}
