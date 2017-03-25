<?php

namespace App\Http\Requests;

use App\Member;
use App\Platoon;
use App\Division;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlatoonForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Platoon $platoon
     * @param Division $division
     * @return bool

     */
    public function authorize(Platoon $platoon)
    {
        return $this->user()->can('update', [$platoon]);

        $this->platoon = $platoon;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leader_id' => [
                // ignore current record
                'unique:platoons,leader_id,' . $this->platoon->id,
                'exists:members,clan_id',
            ],
        ];
    }

    /**
     * Custom error messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'leader_id.unique' => 'Member already assigned as a leader.',
            'leader_id.exists' => 'Member with that clan id does not exist.',
        ];
    }

    public function persist()
    {
        $this->platoon->update(
            $this->only(['name', 'leader_id'])
        );

        /**
         * Assign leader as leader of platoon
         * Place member inside platoon
         * Assign platoon leader position
         */
        if ($this->leader_id) {
            $leader = Member::whereClanId($this->leader_id)->firstOrFail();

            $this->platoon->leader()->associate($leader);
            $leader->platoon()->associate($this->platoon);
            $leader->squad()->dissociate();
            $leader->assignPosition("platoon leader")->save();
        }
    }
}
