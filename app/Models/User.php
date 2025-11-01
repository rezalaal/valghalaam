<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Support\Facades\Hash;
use App\Enums\Education;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements FilamentUser, HasName, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        // 'code',
        'first_name',
        'last_name',
        'company_name',
        'job_title',
        'phone',
        'email',
        'password',
        'is_vip',
        'is_legal',
        'is_foreign',
        'invited_by',
        'city_id',
        'gender_id',
        'education'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'phone_verified_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'education' => \App\Enums\Education::class,
            'is_vip' => 'boolean',
            'is_legal' => 'boolean',
            'is_foreign' => 'boolean',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function getAuthIdentifierName()
    {        
        return 'phone';
    }


    public function canAccessPanel(Panel $panel): bool
    {
        return strtolower($this->email) === 'admin@local.tld';
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function setPasswordAttribute($value)
    {
        if(filled($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function invitees()
    {
        return $this->hasMany(User::class, 'invited_by');
    }

    public function city()
    {
        return $this->belongsTo(IranCity::class);
    }

    public function getEducationLabelAttribute(): ?string
    {
        return $this->education !== null
            ? Education::from($this->education)->label()
            : null;
    }

    public function code()
    {
        return $this->hasOne(Code::class);
    }

    public function getCodeValueAttribute():?string
    {
        return $this->code?->code;
    }

    public function getInviterCodeValueAttribute(): ?string
    {
        return $this->inviter?->code?->code;
    }


}
