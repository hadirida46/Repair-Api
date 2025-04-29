<?php
namespace App\Traits;
trait HasRole
{
    public function isSpecialist()
    {
        return $this->role === 'specialist';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}