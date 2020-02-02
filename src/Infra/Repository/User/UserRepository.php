<?php

namespace App\Infra\Repository\User;

use App\Domains\User\User;
use App\Application\ActiveRecord\ActiveRecordAbstract;
use App\Infra\Repository\RepositoryAbstract;

class UserRepository extends RepositoryAbstract
{
    protected $modelClass = User::class;

    /**
     * Returna an user by email
     * @param string $email
     * @return ActiveRecordAbstract|null
     */
    public function findByEmail(string $email)
    {
        return $this->findOne(['email' => $email]);
    }
}
