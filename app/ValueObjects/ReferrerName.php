<?php

namespace App\ValueObjects;

use App\Models\User;

class ReferrerName
{
    public function __construct(
        public readonly ?string $first_name,
        public readonly ?string $last_name
    ){}

    public function full(): ?string
    {
        if (!$this->first_name && !$this->last_name) {
            return null;
        }

        return trim("{$this->first_name} {$this->last_name}");
    }

    public static function fromUser(?User $user): self
    {
        if (!$user) {
            return new self(null, null);
        }

        return new self($user->first_name, $user->last_name);
    }
}
