<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\ApiLoader;

use eZ\Publish\Core\Persistence\Database\DatabaseHandler;
use Symfony\Component\DependencyInjection\ContainerInterface;

use EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\Gateway\DoctrineDatabase;

class LegacyVatHandlerFactory
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Constructor
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct( ContainerInterface $container )
    {
        $this->container = $container;
    }

    /**
     * Builds the legacy vat handler
     *
     * @param \eZ\Publish\Core\Persistence\Database\DatabaseHandler $dbHandler
     *
     * @return \EzSystems\EzPriceBundle\Core\Persistence\Legacy\Price\VatHandler
     */
    public function buildLegacyVatHandler( DatabaseHandler $dbHandler )
    {
        $legacyTagsHandlerClass = $this->container->getParameter( "ezprice.api.storage_engine.legacy.handler.ezprice.class" );
        return new $legacyTagsHandlerClass(
            new DoctrineDatabase( $dbHandler )
        );
    }
} 