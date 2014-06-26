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
use \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway;
use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\API\Repository\Exceptions\NotImplementedException;

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
     * Gets the price for the given field
     *
     * @see \EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\PriceStorage\Gateway
     * @throws NotImplementedException If the field's VAT handling is set to automatic
     *
     */
    public function getPriceInfo( Field $field )
    {
        $field->value->externalData = $this->fetchPriceData( $field->id, $field->versionNo );
    }

   /**
    * Gets the Price Data.
    *
    * @param int $fieldId
    * @param int $versionNo
    *
    * @throws NotImplementedException If the field's VAT handling is set to automatic
    *
    * @return array Price data. Keys: price, is_vat_included, vat_percentage
    */
    private function fetchPriceData( $fieldId, $versionNo )
    {

        $price = array();
        $priceLegacyData = $this->getPriceLegacyData( $fieldId, $versionNo );

        $price['price'] = $priceLegacyData['data_float'];
        list( $isVatIncluded, $vatTypeId ) = explode( ',', $priceLegacyData['data_text'] );
        $price['is_vat_included'] = $isVatIncluded == 1 ? true : false;
        $price['vat_percentage'] = $this->getVatPercentage( $vatTypeId );

        return $price;
    }

    /**
     * Queries database for get the data_float and data_text of the row
     * with the id $fieldId and version $versionNo
     *
     * @param int $fieldId
     * @param int $versionNo
     *
     * @return array
     */
    private function getPriceLegacyData( $fieldId, $versionNo )
    {
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

        return $statement->fetch();
    }

    /**
     * Get Vat Percentage associated with Vat Type $vat_type or 0 in case automatic VAT is used
     *
     * @todo add the ability to work with automatic VAT Type
     *
     * @param int $vat_type
     *
     * @throws NotImplementedException if vat_type is -1 (Automatic)
     *
     * @return float
     */
    private function getVatPercentage( $vat_type )
    {
        if ( $vat_type == -1 )
        {
            throw new NotImplementedException( 'Automatic VAT Handling is not implemented yet' );
        }

        $dbHandler = $this->getConnection();
        $selectQuery = $dbHandler->createSelectQuery();
        $selectQuery->select( 'percentage' )
            ->from( $dbHandler->quoteTable( "ezvattype" ) )
            ->where(
                $selectQuery->expr->eq(
                    $dbHandler->quoteColumn( 'id' ),
                    $selectQuery->bindValue( $vat_type )
                )
            );

        $statement = $selectQuery->prepare();
        $statement->execute();
        $vatPercentage = $statement->fetchColumn();

        return $vatPercentage;
    }
}
