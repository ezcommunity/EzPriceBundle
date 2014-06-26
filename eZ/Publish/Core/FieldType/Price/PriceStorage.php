<?php
/**
 * Price FieldType external storage handler.
 * Handles the VAT rate.
 */

namespace EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price;

use eZ\Publish\Core\FieldType\GatewayBasedStorage;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;
use eZ\Publish\SPI\Persistence\Content\Field;
use eZ\Publish\API\Repository\Exceptions\NotImplementedException;
use Psr\Log\LoggerInterface;

/**
 * Converter for Price field type external storage
 */
class PriceStorage extends GatewayBasedStorage
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param \eZ\Publish\Core\FieldType\StorageGateway[] $gateways
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct( array $gateways = array(), LoggerInterface $logger = null )
    {
        parent::__construct( $gateways );
        $this->logger = $logger;
    }

    /**
     * @see \eZ\Publish\SPI\FieldType\FieldStorage
     */
    public function storeFieldData( VersionInfo $versionInfo, Field $field, array $context )
    {
        $gateway = $this->getGateway( $context );
        return $gateway->storeFieldData( $versionInfo, $field );
    }

    /**
     * Populates $field value property based on the external data.
     *
     * @param \eZ\Publish\SPI\Persistence\Content\VersionInfo $versionInfo
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     *
     * @return array|void
     */
    public function getFieldData( VersionInfo $versionInfo, Field $field, array $context )
    {
        $gateway = $this->getGateway( $context );

        try
        {
            return $gateway->getPriceInfo( $field );
        }
        catch ( NotImplementedException $e )
        {
            if ( isset( $this->logger ) )
            {
                $this->logger->error( $e->getMessage() );
            }
        }
    }

    /**
     * Price fieldtype doesn't need to delete any external data
     *
     * @param VersionInfo $versionInfo
     * @param array $fieldIds
     * @param array $context
     *
     * @return void
     */
    public function deleteFieldData( VersionInfo $versionInfo, array $fieldIds, array $context )
    {
    }

    /**
     * Checks if field type has external data to deal with
     *
     * @return boolean
     */
    public function hasFieldData()
    {
        return true;
    }

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\VersionInfo $versionInfo
     * @param \eZ\Publish\SPI\Persistence\Content\Field $field
     * @param array $context
     *
     * @return \eZ\Publish\SPI\Persistence\Content\Search\Field[]
     */
    public function getIndexData( VersionInfo $versionInfo, Field $field, array $context )
    {
    }
}