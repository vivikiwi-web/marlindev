<?php

class Validate {
    private $passed = false, $errors = [], $db = null;

    public function __construct() {
        $this->db = DB::getInstance();
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
                    $this->addError( "{$item} поля обязательны для заполнения." );
                } else if ( !empty($fieldValue) ) {
                    switch ( $rule ) {

                        case "min":
                            if ( strlen($fieldValue) < $rule_value ) {
                                $this->addError("{$item} должен состоять минимум из {$rule_value} символов.");
                            }
                        break;

                        case "max":
                            if ( strlen($fieldValue) > $rule_value ) {
                                $this->addError("{$item} должно быть максимум {$rule_value} символов.");
                            }
                        break;

                        case "matches":
                            if ( $fieldValue != $method[$rule_value] ) {
                                $this->addError("{$item} должен соответствовать {$rule_value}.");
                            }
                        break;

                        case "email":
                            if ( !filter_var($fieldValue, FILTER_VALIDATE_EMAIL) ) {
                                $this->addError("{$item} не неправильный.");
                            }
                        break;

                        case "unique":
                            $dbValue = $this->db->get( $rule_value, [ $item, "=", $fieldValue ]);
                            if ( $dbValue->count() ) {
                                $this->addError("{$fieldValue} уже существует.");
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