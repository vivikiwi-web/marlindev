<?php

namespace App\Models;

use Core\QueryBuilder;
use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;

class User {
    private $query, $result, $auth, $selector, $token;

    public function __construct( QueryBuilder $query, Auth $auth)
    {
        $this->query = $query;
        $this->auth = $auth;
    }

    public function getUsers( $table ) {

        $this->result = $this->query->findAll( $table );
        return $this->result;

    }

    public function register( $post ) {
        try {
            $userId = $this->auth->register(
                $post['email'], 
                $post['password'], 
                $post['username'], 
                function ($selector, $token) {
                    $this->token = $token;
                    $this->selector = $selector;
            });
        
            return $userId;
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }
    }

    public function getSelector() {
        return $this->selector;
    }

    public function getToken() {
        return $this->token;
    }

}