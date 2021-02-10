<?php

class Validate {
    private $passed = false, $errors = [], $db = null;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

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

    private function addError( string $errorMessage ) {
        $this->errors[] = $errorMessage;
    }

    public function errors () {
        return $this->errors;
    }

    public function passed () {
        return $this->passed;
    }
}