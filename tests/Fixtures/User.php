<?php

namespace GeneaLabs\LaravelImpersonator\Tests\Fixtures;

use GeneaLabs\LaravelImpersonator\Tests\Fixtures\Database\Factories\UserFactory;
use GeneaLabs\LaravelImpersonator\Traits\Impersonatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Impersonatable;

    protected $canImpersonateFlag = false;
    protected $canBeImpersonatedFlag = true;

    protected $guarded = [];

    public function getCanImpersonateAttribute(): bool
    {
        return $this->canImpersonateFlag;
    }

    public function setCanImpersonateAttribute(bool $value): void
    {
        $this->canImpersonateFlag = $value;
    }

    public function getCanBeImpersonatedAttribute(): bool
    {
        return $this->canBeImpersonatedFlag;
    }

    public function setCanBeImpersonatedAttribute(bool $value): void
    {
        $this->canBeImpersonatedFlag = $value;
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
