<?php

namespace Financas\Auth;

use Financas\Models\UserInterface;

class Auth implements AuthInterface
{
    /**
    * @var JasnyAuth
    */
    private $jasnyAuth;
    
    /**
     * Auth Constructor
     */
    function __construct(JasnyAuth $jasnyAuth)
    {
        $this->jasnyAuth = $jasnyAuth;
        $this->sessionStart();
    }


    public function login(array $credentials): bool
    {
        list('email' => $email, 'password' => $password) = $credentials;
        return $this->jasnyAuth->login($email, $password) !== null;
    }

    public function check(): bool 
    {
        return $this->user() !== null;
    }
    
    public function user(): ?UserInterface 
    {
        return $this->jasnyAuth->user();
    }

    public function logout(): void 
    {
        $this->jasnyAuth->logout();
    }
    
    public function hashPassword(string $password): string
    {
        return $this->jasnyAuth->hashPassword($password);
    }

    protected function sessionStart()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }



}
