<?php namespace GeneaLabs\LaravelImpersonator\Policies;

class Impersonation
{
    public function impersonation($impersonator) : bool
    {
        return $impersonator->canImpersonate ?? false;
    }
}
