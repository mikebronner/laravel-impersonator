<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Fixtures\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use GeneaLabs\LaravelImpersonator\Traits\Impersonatable;

class User extends Authenticatable
{
    use HasFactory;
    use Impersonatable;

    protected $canImpersonateFlag = false;
    protected $canBeImpersonatedFlag = true;

    public function getCanImpersonateAttribute() : bool
    {
        return $this->canImpersonateFlag;
    }

    public function setCanImpersonateAttribute(bool $value)
    {
        $this->canImpersonateFlag = $value;
    }

    public function getCanBeImpersonatedAttribute() : bool
    {
        return $this->canBeImpersonatedFlag;
    }

    public function setCanBeImpersonatedAttribute(bool $value)
    {
        $this->canBeImpersonatedFlag = $value;
    }
}
