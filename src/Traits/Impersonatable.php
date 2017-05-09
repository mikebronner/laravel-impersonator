<?php namespace GeneaLabs\LaravelImpersonator\Traits;

trait Impersonatable
{
    protected $canImpersonate = false;
    protected $canBeImpersonated = true;

    public function getCanImpersonateAttribute() : bool
    {
        return $this->canImpersonate;
    }

    public function setCanImpersonateAttribute(bool $value)
    {
        $this->canImpersonate = $value;
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
