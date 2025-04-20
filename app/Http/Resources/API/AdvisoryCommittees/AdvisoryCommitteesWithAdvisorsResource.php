<?php

namespace App\Http\Resources\API\AdvisoryCommittees;

use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use App\Http\Resources\AccountResourceShort;
use JsonSerializable;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersAdvisorys;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class AdvisoryCommitteesWithAdvisorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $advisors_ids = LawyersAdvisorys::where('advisory_id', $this->id)->pluck('account_details_id')->toArray();
        $lawyers = Account::whereHas('lawyerDetails', function ($query) use ($advisors_ids) {
            $query->whereIn('id', $advisors_ids)->where('is_advisor', 1);
        })->where('status', '2')->get();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'advisors_available_counts' => getAdvisorCatLawyersCount($this->id),
            'advisors' => AccountResourcePublic::collection($lawyers),

        ];
    }
}
