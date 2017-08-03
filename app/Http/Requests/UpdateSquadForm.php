<?php

namespace App\Http\Requests;

use App\Member;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateSquadForm
 *
 * @package App\Http\Requests
 */
class UpdateSquadForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('squad'));

        $this->squad = $squad;
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
                'unique:squads,leader_id,' . $this->squad->id,
                'exists:members,clan_id',
            ],
            'name' => 'required|max:40',
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

    /**
     * Save the squad
     */
    public function persist()
    {
        $this->squad->update(
            $this->only(['name', 'leader_id'])
        );

        if ($this->member_ids) {
            $this->assignMembersTo($this->squad);
        }

        if ($this->leader_id) {
            $this->assignLeaderTo($this->squad);
        } else {
            $this->resetLeaderOf($this->squad);
        }
    }

    /**
     * Assign members to a squad
     *
     * @param $squad
     */
    private function assignMembersTo($squad)
    {
        collect(json_decode($this->member_ids))->each(function ($memberId) use ($squad) {
            $member = Member::find($memberId);
            $member->squad()->associate($squad);
            $member->save();
        });
    }

    /**
     * Assign a leader
     *
     * @param $squad
     */
    private function assignLeaderTo($squad)
    {
        $leader = Member::whereClanId($this->leader_id)->firstOrFail();

        $squad->leader()->associate($leader)->save();

        $leader->squad()->associate($squad)
            ->platoon()->associate($this->route('platoon'))
            ->assignPosition("squad leader")
            ->save();
    }

    /**
     * Reset the leader
     *
     * @param $squad
     */
    private function resetLeaderOf($squad)
    {
        $squad->leader()->dissociate()
            ->save();
    }
}
