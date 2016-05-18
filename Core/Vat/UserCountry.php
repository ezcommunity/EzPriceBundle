<?php 

namespace EzSystems\EzPriceBundle\Core\Vat;

use EzSystems\EzPriceBundle\API\Vat\UserCountry as UserCountryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Service used to find out what the users current country is.
 */
class UserCountry implements UserCountryInterface
{
    /**
     * Symfony Request stack, used to get session information
     * 
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * The country that we should default to if the users country cannot
     * be found. Needs to be an Alpha2 code for the country
     * 
     * @var string
     */
    protected $defaultUserCountry;

    /**
     * The name of the session variable that contains the users country
     * 
     * @var string
     */
    protected $countrySessionVariableName;

    /**
     * __construct
     * 
     * @param RequestStack $requestStack               
     * @param string       $defaultUserCountry         
     * @param string       $countrySessionVariableName 
     */
    public function __construct(
        RequestStack $requestStack, 
        $defaultUserCountry,
        $countrySessionVariableName = "UserPreferredCountry"
    )
    {
        $this->requestStack = $requestStack;
        $this->defaultUserCountry = $defaultUserCountry;
        $this->countrySessionVariableName = $countrySessionVariableName;
    }

    /**
     * Used to fetch the currect users country from the session, If it cannot 
     * be found the the default country will be returned
     * 
     * @return string
     */
    public function fetchUsersCountry()
    {
        $masterRequest = $this->requestStack->getMasterRequest();
        $session = $masterRequest->getSession();

        if ($session->has($this->countrySessionVariableName)) {
            // Fetch the users country from their session
            return $session->get($this->countrySessionVariableName);
        } else {
            // Get default user country
            return $this->defaultUserCountry;
        }
    }
}