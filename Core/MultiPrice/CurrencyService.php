<?php

/**
 * This file is part of the EzPriceBundle package.
 *
 * @author Bluetel Solutions <developers@bluetel.co.uk>
 * @author Joe Jones <jdj@bluetel.co.uk>
 * 
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\EzPriceBundle\Core\MultiPrice;

use EzSystems\EzPriceBundle\API\MultiPrice\CurrencyService as CurrencyServiceInterface;
use EzSystems\EzPriceBundle\API\MultiPrice\Values\Currency;
use EzSystems\EzPriceBundle\SPI\Persistence\MultiPrice\CurrencyHandler;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Service used to fetch the currency for the current user.
 */
class CurrencyService implements CurrencyServiceInterface
{
    /**
     * The request stack, used to retrive session information
     * 
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Currency handler, used to retrive a currency object
     * 
     * @var CurrencyHandler
     */
    protected $currencyHandler;

    /**
     * The default currency to use if we cannot find one for the user
     * 
     * @var string
     */
    protected $defaultUserCurrency;

    /**
     * The session variable name of the currency session variable.
     * 
     * @var string
     */
    protected $currencySessionVariableName;

    /**
     * __construct 
     * 
     * @param RequestStack    $requestStack                
     * @param CurrencyHandler $currencyHandler             
     * @param string          $defaultUserCurrency 3 character code for the currency
     * @param string          $currencySessionVariableName defaults to UserPreferredCurrency
     */
    public function __construct(
        RequestStack $requestStack,
        CurrencyHandler $currencyHandler,
        $defaultUserCurrency,
        $currencySessionVariableName = "UserPreferredCurrency"
    )
    {
        $this->requestStack = $requestStack;
        $this->currencyHandler = $currencyHandler;
        $this->defaultUserCurrency = $defaultUserCurrency;
        $this->currencySessionVariableName = $currencySessionVariableName;
    }

    /**
     * Get the currency code for the current user
     * 
     * @return string the current users currency code
     */
    public function getUsersCurrencyCode()
    {
        $masterRequest = $this->requestStack->getMasterRequest();
        $session = $masterRequest->getSession();

        if ($session->has($this->currencySessionVariableName)) {
            // Fetch the users currency from their session
            return $session->get($this->currencySessionVariableName);
        } else {
            // Get default user country
            return $this->defaultUserCurrency;
        }
    }

    /**
     * Fetch the currency code that should be used for the current user.
     * 
     * @return Currency the currency object for the current user.
     */
    public function getUsersCurrency()
    {
        return $this->currencyHandler
                    ->getCurrencyByCode($this->getUsersCurrencyCode());
    }
}