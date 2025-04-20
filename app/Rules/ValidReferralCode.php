<?php

namespace App\Rules;

use App\Models\ReferralCode;
use Closure;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidReferralCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_null($value)) {

            $referralCodeExists = ReferralCode::where('referral_code', $value)->exists();

            if (!$referralCodeExists) {
                $fail('رمز المشاركة غير صحيح');
            }
        }
    }
}
