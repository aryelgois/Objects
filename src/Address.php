<?php
/**
 * This Software is part of aryelgois\objects and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\objects;

/**
 * A Person object defines someone in the real world
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/objects
 * @version 0.1
 */
class Address
{
    /**
     * Road, Avenue, these stuff
     *
     * @var string
     */
    public $street;
    
    /**
     * Buildings' number. An apartment's should go into $details
     *
     * @var string
     */
    public $number;
    
    /**
     * Here you put additional information
     *
     * @var string
     */
    public $detail;
    
    /**
     * Implementation may vary from country to country
     *
     * @var string
     */
    public $zipcode;
    
    /**
     * A county's small division
     *
     * @var string
     */
    public $neighborhood;
    
    /**
     * It's the city
     *
     * @var string
     */
    public $county;
    
    /**
     * Usually, a country is divided into states
     *
     * @var string
     */
    public $state;
    
    /**
     * Up to now 195 countries exist
     *
     * @see http://www.worldometers.info/geography/how-many-countries-are-there-in-the-world/
     *
     * @var string
     */
    public $country;
    
    /**
     * Creates a new Address object
     *
     * @param string $street       Do i need to repeat what is above?
     * @param string $number       ..
     * @param string $zipcode      ..
     * @param string $neighborhood ..
     * @param string $county       ..
     * @param string $state        ..
     * @param string $country      ..
     * @param string $detail       Optional information
     */
    public function __construct($street, $number, $zipcode, $neighborhood, $county, $state, $country, $detail = '')
    {
        /*
         * Is there an easier way?
         */
        $this->street = $street;
        $this->number = $number;
        $this->detail = $detail;
        $this->zipcode = $zipcode;
        $this->neighborhood = $neighborhood;
        $this->document = $county;
        $this->state = $state;
        $this->country = $country;
    }
}
