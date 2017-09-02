<?php
/**
 * This Software is part of aryelgois\objects and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\objects;

/**
 * A Person object defines someone in the real world. It is a basic setup and
 * should be extended for your use case.
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/objects
 * @version 0.1
 */
class Person
{
    /**
     * Every person should have a name..
     *
     * Why people insist in separating First name and Last name? It is just a
     * name. If you want a formatting, do it before populating this property
     *
     * @var string
     */
    public $name;
    
    /**
     * A document defined by the government
     *
     * Let's do like this: Store just the numbers. On output, pass to a
     * formatting method to add dots, dashes or anything.
     *
     * @var string
     */
    public $document;
    
    /**
     * A person may have more than one address, and it can be defined as a plain
     * list, or maybe 'home', 'work', whatever. You define in your application
     *
     * @var Address[]
     */
    public $address = [];
    
    /**
     * Creates a new Person object
     *
     * It's not required to pass any address. This is up to your implementation
     * in how it will be used.
     *
     * @param string $name     Person's name
     * @param string $document Person's document
     */
    public function __construct(string $name, string $document)
    {
        $this->name = $name;
        $this->document = $document;
    }
}
