<?php
declare(strict_types=1);

namespace Financas\Models;

use Illuminate\Database\Eloquent\Model;
use Jasny\Auth\User as JasnyUser;

class User extends Model implements JasnyUser, UserInterface {
    //Mass Assignment
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password'
    ];

    /**
    * Get user id
    *
    * @return int|string
    */
    public function getId() {
        return (int)$this->id;
    }

    /**
     * Get user's username
     *
     * @return string
     */
    public function getUsername():string
    {
        return $this->email;
    }
    
    /**
     * Get user's hashed password
     *
     * @return string
     */
    public function getHashedPassword():string
    {
        return $this->password;
    }

    public function onLogin(): boolean {
        
    }

    public function onLogout(): void {
        
    }

}
