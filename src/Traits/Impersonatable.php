<?php namespace GeneaLabs\LaravelImpersonator\Traits;

trait Impersonatable
{
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
        return $this->can_be_impersonated ?? true;
    }

    public function setCanBeImpersonatedAttribute(bool $value)
    {
        $this->can_be_impersonated = $value;
    }
}
