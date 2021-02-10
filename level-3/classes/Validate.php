<?php

class Validate {
    private $passed = false, $errors = [], $db = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Check validation
     *
     * @param $_POST,$_GET $method
     * @param array $items
     * @return Validate
     */
    public function check ( $method, array $items = [] ) {
        foreach ( $items as $item => $rules ) {
            foreach ( $rules as $rule => $rule_value) {

                $fieldValue = $method[$item];

                if ( $rule == "required" && empty($fieldValue) ) {
                    $this->addError( "{$item} fields is required." );
                } else if ( !empty($fieldValue) ) {
                    switch ( $rule ) {

                        case "min":
                            if ( strlen($fieldValue) < $rule_value ) {
                                $this->addError("{$item} must be a minimum of {$rule_value} characters.");
                            }
                        break;

                        case "max":
                            if ( strlen($fieldValue) > $rule_value ) {
                                $this->addError("{$item} must be a maximum of {$rule_value} characters.");
                            }
                        break;

                        case "matches":
                            if ( $fieldValue != $method[$rule_value] ) {
                                $this->addError("{$item} must match {$rule_value}.");
                            }
                        break;

                        case "email":
                            if ( !filter_var($fieldValue, FILTER_VALIDATE_EMAIL) ) {
                                $this->addError("{$item} is not valid.");
                            }
                        break;

                        case "unique":
                            $dbValue = $this->db->get( $rule_value, [ $item, "=", $fieldValue ]);
                            if ( $dbValue->count() ) {
                                $this->addError("{$fieldValue} already exists.");
                            }
                        break;
                    }
                }

            }
        }

        if ( empty($this->errors) ) {
            $this->passed = true;
        } 

        return $this;
    }

    /**
     * Add error message
     *
     * @param string $errorMessage
     * @return void
     */
    private function addError( string $errorMessage ) {
        $this->errors[] = $errorMessage;
    }

    /**
     * Return errors array variable
     *
     * @return array
     */
    public function errors () {
        return $this->errors;
    }

    /**
     * Return passed variable
     *
     * @return boolean
     */
    public function passed () {
        return $this->passed;
    }
}