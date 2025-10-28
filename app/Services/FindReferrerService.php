<?php

namespace App\Services;

use App\Models\Code;
use App\ValueObjects\ReferrerName;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class FindReferrerService
{
    public function __construct(
        protected UserRepository $users
    ){}

    public function handle(int $code): ?string
    {                

        $validator = Validator::make(['code' => $code], [
            'code' => ['required', 'integer', 'exists:codes,code'],
        ]);

        if ($validator->fails()) {            
            return null;
        }        

        $code = Code::where('code', $code)->first();                
        
        return ReferrerName::fromCode($code)->full();
    }
}
