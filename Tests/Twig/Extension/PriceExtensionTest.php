<?php
/**
 * This file is part of the EzPriceBundle package.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Tests\Twig\Extension;

use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\Core\Repository\Values\Content\VersionInfo;
use EzSystems\EzPriceBundle\API\Price\Values\PriceWithVatData;
use EzSystems\EzPriceBundle\API\Price\Values\VatRate;
use EzSystems\EzPriceBundle\Core\Price\PriceValueWithVatDataCalculator;
use EzSystems\EzPriceBundle\eZ\Publish\Core\FieldType\Price\Value as PriceValue;
use EzSystems\EzPriceBundle\Twig\Extension\PriceExtension;
use Psr\Log\LoggerInterface;
use Twig_Test_IntegrationTestCase;

/**
 * @covers \EzSystems\EzPriceBundle\Twig\Extension\PriceExtension
 */
class PriceExtensionTest extends Twig_Test_IntegrationTestCase
{
    /**
     * @var \Psr\Log\LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $loggerMock;

    /**
     * @return array
     */
    protected function getExtensions()
    {
        return [
            new PriceExtension(
                $this->getVatServiceMock(),
                new PriceValueWithVatDataCalculator(),
                $this->getLoggerMock()
            )
        ];
    }

    /**
     * @return \Psr\Log\LoggerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected function getLoggerMock()
    {
        if ( !isset( $this->loggerMock ) )
        {
            $this->loggerMock = $this->getMockForAbstractClass(
                "Psr\\Log\\LoggerInterface"
            );
        }

        return $this->loggerMock;
    }

    private function getVatServiceMock()
    {
        $vatRate = new VatRate( array( 'percentage' => 10.0, 'name' => 'test' ) );

        $mock = $this->getMock( 'EzSystems\EzPriceBundle\API\Price\VatService' );
        $mock->expects( $this->any() )
            ->method( 'loadVatRate' )
            ->will( $this->returnValue( $vatRate ) );

        return $mock;
    }

    /**
     * @param float $price
     * @param bool $isVatIncluded
     *
     * @return Field
     */
    protected function createField( $price, $isVatIncluded )
    {
        return new Field(
            array(
<<<<<<< HEAD
                'value' => new PriceValue(
=======
                'value' => new Value(
>>>>>>> Made the Calculator return a Value
                    array(
                        'price' => $price,
                        'isVatIncluded' => $isVatIncluded
                    )
                )
            )
        );
    }

    protected function createVersionInfo()
    {
        return new VersionInfo( array( 'versionNo' => 1 ) );
    }

    /**
     * @return string
     */
    protected function getFixturesDir()
    {
        return __DIR__ . '/_fixtures/ezprice_value';
    }
}
