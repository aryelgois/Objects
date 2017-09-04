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
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/objects
 * @version 0.3
 */
class Address
{
    /**
     * Handles database interaction. It is used for getting the country, state
     * and county.
     *
     * @var Database
     */
    protected $database;
    
    /**
     * Up to now 195 countries exist
     *
     * Actually, there are a few more, but they aren't independent
     *
     * @var mixed[]
     */
    public $country;
    
    /**
     * Usually, a country is divided into states
     *
     * It could be another name, but let's keep it simple. If you know a more
     * generic name, please pull request on GitHub
     *
     * @var mixed[]
     */
    public $state;
    
    /**
     * It's the city or a small town
     *
     * @var mixed[]
     */
    public $county;
    
    /**
     * Creates a new Address object
     *
     * @param Database $database  An object to handle database interaction. Make
     *                            sure it is connected to the address database
     * @param integer  $county_id An index in counties table
     *
     * @throws RuntimeException If could not load from Database
     */
    public function __construct(Database $database, $county_id)
    {
        $this->database = $database;
        if (!$this->loadData($county_id)) {
            throw new RuntimeException('Could not load from Database');
        }
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
    protected function loadData($county_id)
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
        $this->country = $country;
        $this->state = $state;
        $this->county = $county;
        return true;
    }
    
    /**
     * Returns all stored data in an array
     *
     * @return array[]
     */
    public function dump()
    {
        return [
            'country' => $this->country,
            'state' => $this->state,
            'county' => $this->county
        ];
    }
}
