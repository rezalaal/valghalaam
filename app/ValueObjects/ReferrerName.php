<?php

namespace App\ValueObjects;

use App\Models\Code;
use App\Models\User;

class ReferrerName
{
    public function __construct(
        public readonly ?int $user_id,
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

    public function id(): ?int
    {
        return $this->user_id;
    }

    public static function fromCode(?Code $code): self
    {
        if (!$code) {            
            return new self(null, null, null);
        }
        
        if(!$code->user) {
            return new self(0,"سفیر", "پویش");
        }
        return new self($code->user_id, $code->user?->first_name, $code->user?->last_name);
    }
}
