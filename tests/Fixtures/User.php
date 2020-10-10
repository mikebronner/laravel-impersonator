<?php namespace GeneaLabs\LaravelImpersonator\Tests\Fixtures;

use App\Models\User as OG;
use GeneaLabs\LaravelImpersonator\Traits\Impersonatable;

class User extends OG
{
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
