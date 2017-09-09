<?php
/**
 * This Software is part of aryelgois\Objects and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Objects;

use aryelgois\Utils\Database;

/**
 * A Full Address object to reference a specific place in the world
 *
 * It extends Address and require its dependencies.
 *
 * This class allows you to define more specific information about the address,
 * which should be provided by your clients.
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/Objects
 */
class FullAddress extends Address
{
    /**
     * A county's small division
     *
     * @var string
     */
    public $neighborhood;
    
    /**
     * Road, Avenue, these stuff
     *
     * @var string
     */
    public $place;
    
    /**
     * Buildings' number. An apartment's should go into $details
     *
     * Should be an integer, but you can use a string like '13-A', or something
     * to tell there is no number at all
     *
     * @var mixed
     */
    public $number;
    
    /**
     * Used by mailing to locate a place. It's implementation may vary from
     * country to country
     *
     * @var string
     */
    public $zipcode;
    
    /**
     * Here you put additional and complementary information
     *
     * @var string
     */
    public $detail;
    
    /**
     * Creates a new Address object
     *
     * @param Database $database     An object to handle database interaction
     * @param string   $county_id    An index in counties table
     * @param string   $neighborhood See above
     * @param string   $place        ..
     * @param mixed    $number       ..
     * @param string   $zipcode      ..
     * @param string   $detail       Optional information
     */
    public function __construct(
        Database $database,
        $county_id,
        $neighborhood,
        $place,
        $number,
        $zipcode,
        $detail = ''
    ) {
        parent::__construct($database, $county_id);
        $this->neighborhood = $neighborhood;
        $this->place = $place;
        $this->number = $number;
        $this->zipcode = $zipcode;
        $this->detail = $detail;
    }
    
    /**
     * Returns all stored data in an array
     *
     * @return array[]
     */
    public function dump()
    {
        return array_merge(
            parent::dump(),
            [
                'neighborhood' => $this->neighborhood,
                'place' => $this->place,
                'number' => $this->number,
                'zipcode' => $this->zipcode,
                'detail' => $this->detail
            ]
        );
    }
}
