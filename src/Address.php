<?php
/**
 * This Software is part of aryelgois\objects and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\objects;

use aryelgois\utils\Database;

/**
 * An Address object to reference a place in the world
 *
 * It is built on top of aryelgois\databases\Address, which means it expects
 * you have a database following that scheme in your server.
 *
 * @see https://www.github.com/aryelgois/databases
 *
 * Also, to access the database, this class uses aryelgois\utils\Database to
 * handle the connection. As it is an abstract class, you have to extend it and
 * provide your method for database errors, accordingly to your project needs.
 *
 * @see https://www.github.com/aryelgois/utils
 *
 * Even though, some fields aren't available in the database and you need to set
 * them. These are for a more local information and should be provided by your
 * clients.
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/objects
 * @version 0.2
 */
class Address
{
    /**
     * Handles database interaction. It is used for getting the county, state
     * and country.
     *
     * @var Database
     */
    protected $database;
    
    /**
     * Holds all loaded data about the address.
     *
     * @var mixed[]
     */
    public $data = [];
    
    /**
     * Creates a new Address object
     *
     * @param Database $database An object to handle database connection and
     *                           other stuffs. Make sure it is connected to the
     *                           address database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    /**
     * Retrieves some data from the Database
     *
     * It will ask for the county, state and country entries, based on the
     * county index, because it's table is in the tip of the tables chain in the
     * Database.
     *
     * @param integer $county_id The county index to fetch all the necessary
     *                           data from the Database. You can know this from
     *                           a registry form sent by your client.
     *
     * @return boolean For success of failure
     */
    public function loadData($county_id)
    {
        // fetch county
        $query = "SELECT `state`, `name` FROM `counties` WHERE `id` = ?";
        $county = Database::fetch($this->database->prepare($query, 'i', [$county_id]));
        if (empty($county)) {
            return false;
        }
        $county = $county[0];
        
        // fetch state
        $query = "SELECT `country`, `code`, `name` FROM `states` WHERE `id` = ?";
        $state = Database::fetch($this->database->prepare($query, 'i', [$county['state']]));
        if (empty($state)) {
            return false;
        }
        $state = $state[0];
        
        // fetch country
        $query = "SELECT `code_a2`, `code_a3`, `code_number`, `name_en`, `name_local` FROM `countries` WHERE `id` = ?";
        $country = Database::fetch($this->database->prepare($query, 'i', [$state['country']]));
        if (empty($country)) {
            return false;
        }
        $country = $country[0];
        
        // store data
        $county['id'] = $county_id;
        $state['id'] = $county['state'];
        $country['id'] = $state['country'];
        unset($county['state'], $state['country']);
        $this->data['county'] = $county;
        $this->data['state'] = $state;
        $this->data['country'] = $country;
        return true;
    }
    
    /**
     * Allows you to set the missing fields after calling getData()
     *
     * The keys in $data depends on your project. I recomend the following:
     * - street:       Road, Avenue, these stuff
     *
     * - number:       Building numbers. should be an integer, but you can use a
     *                 string like '13-A', or something to tell there is no
     *                 number at all
     *
     * - neighborhood: A county's small division
     *
     * - zipcode:      Used by mailing to locate a place. It's implementation
     *                 may vary from country to country
     *
     * - detail:       Here you put additional and complementary information
     *
     * @param mixed[] $data Its contents are merged into $this->data, so be
     *                      careful not to replace the data from getData(),
     *                      unless it is intentional.
     */
    public function setData($data)
    {
        $this->data = array_replace($this->data, $data);
    }
}
