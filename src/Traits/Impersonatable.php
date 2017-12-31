<?php namespace GeneaLabs\LaravelImpersonator\Traits;

trait Impersonatable
{
    protected $canImpersonate = false;
    protected $canBeImpersonated = true;

    public function getCanImpersonateAttribute() : bool
    {
        return $this->can_impersonate ?? false;
    }

    public function setCanImpersonateAttribute(bool $value)
    {
        $this->can_impersonate = $value;
    }

    public function getCanBeImpersonatedAttribute() : bool
    {
        return $this->canBeImpersonated;
    }

    public function setCanBeImpersonatedAttribute(bool $value)
    {
        $this->canBeImpersonated = $value;
    }
}
