<?php namespace GeneaLabs\LaravelImpersonator\Traits;

trait Impersonatable
{
    public function getCanImpersonateAttribute() : bool
    {
        return $this->attributes["can_impersonate"]
            ?? false;
    }

    public function setCanImpersonateAttribute(bool $value)
    {
        $this->attributes["can_impersonate"] = $value;
    }

    public function getCanBeImpersonatedAttribute() : bool
    {
        return $this->attributes["can_be_impersonated"]
            ?? true;
    }

    public function setCanBeImpersonatedAttribute(bool $value)
    {
        $this->attributes["can_be_impersonated"] = $value;
    }
}
