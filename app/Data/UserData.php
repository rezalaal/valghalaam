<?php

namespace App\Data;

use App\Models\User;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public ?int $id,
        public ?int $code,
        public ?string $first_name,
        public ?string $last_name,
        public ?string $company_name,
        public ?string $job_title,
        public string $phone,
        public ?string $email,
        public bool $is_vip,
        public bool $is_legal,
        public bool $is_foreign,
        public ?string $avatar,
        public ?int $city_id,
        public ?int $gender_id,
        public ?int $education,
        public ?int $invited_by
    ) {}

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            code: $user->code,
            first_name: $user->first_name,
            last_name: $user->last_name,
            company_name: $user->company_name,
            job_title: $user->job_title,
            phone: $user->phone,
            email: $user->email,
            is_vip: (bool) $user->is_vip,
            is_legal: (bool) $user->is_legal,
            is_foreign: (bool) $user->is_foreign,
            avatar: $user->getFirstMediaUrl('avatar'),
            city_id: $user->city_id,
            gender_id: $user->gender_id,
            education: $user->education?->value,
            invited_by: $user->invited_by
        );
    }
}
