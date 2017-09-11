<?php
/**
 * This Software is part of aryelgois\Objects and is provided "as is".
 *
 * @see LICENSE
 */

namespace aryelgois\Objects;

use aryelgois\Utils;

/**
 * A Person object defines someone in the real world. It is a basic setup and
 * should be extended for your use case.
 *
 * @author Aryel Mota Góis
 * @license MIT
 * @link https://www.github.com/aryelgois/Objects
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
     * has the keys 'type' and 'number'
     *
     * @var mixed[]
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
        $this->document = self::validateDocument($document);
    }
    
    /**
     * Validates a document as Brazilian CPF or CNPJ
     *
     * @param string $doc Document to be validated (11 or 14 digits, but other
     *                    characters are ignored)
     *
     * @return mixed[] With keys 'type' and 'number'
     *
     * @throws UnexpectedValueException If document is invalid
     */
    public static function validateDocument($doc)
    {
        $type = 1;
        $number = Utils\Validation::cpf($doc);
        if ($number == false) {
            $type = 2;
            $number = Utils\Validation::cnpj($doc);
        }
        if ($number == false) {
            throw new \UnexpectedValueException('Not a valid document');
        }
        return ['type' => $type, 'number' => $number];
    }
    
    /**
     * Formats a Person Document
     *
     * @param boolean $prepend If should prepend the document name
     *
     * @return string
     */
    public function formatDocument($prepend = false)
    {
        if ($this->document['type'] == 1) {
            return ($prepend ? 'CPF: ' : '') . Utils\Format::cpf($this->document['number']);
        } elseif ($this->document['type'] == 2) {
            return ($prepend ? 'CNPJ: ' : '') . Utils\Format::cnpj($this->document['number']);
        }
        return $this->document['number'];
    }
}
