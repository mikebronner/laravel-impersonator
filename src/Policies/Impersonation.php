<?php namespace GeneaLabs\LaravelImpersonator\Policies;

class Impersonation
{
    public function impersonation($user) : bool
    {
        return $user->canImpersonate
            ?? false;
    }
}
