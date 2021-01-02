<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMemberRank extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->member);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'created_at' => 'required',
            'rank' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value >= auth()->user()->member->rank_id && auth()->user()->member->rank_id >= 5 && !$this->user()->isRole('admin')) {
                        $fail("You are not authorized to set that rank");
                    }
                }
            ]
        ];
    }
}
