<?php namespace GeneaLabs\LaravelImpersonator\Traits;

trait Impersonatable
{
    protected $canImpersonate;
    protected $canBeImpersonated;

    public function getCanImpersonateAttribute() : bool
    {
        return true;
        // dd($this->canImpersonate);
        return $this->canImpersonate ?? false;
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
