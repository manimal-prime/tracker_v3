<?php

namespace App\Models\Slack\Commands;

use App\Models\Member;
use App\Models\MemberHistory;
use App\Models\Rank;
use App\Models\Slack\Base;
use App\Models\Slack\Command;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Search
 *
 * @package App\Slack\Commands
 */
class RankHistory extends Base implements Command
{
    private $content = [];

    public function __construct($data)
    {
        parent::__construct($data);

        $this->request = $data;
    }

    /**
     * @return array
     */
    public function handle()
    {
        if (strlen($this->params) < 3) {
            return [
                'text' => "Your search criteria must be 3 characters or more",
            ];
        }

        $this->member = Member::where('name', 'LIKE', "%{$this->params}%")->get();

        if ($this->member) {

            $division = ($this->member->division)
                ? "{$this->member->division->name} Division"
                : "Ex-AOD";

            $this->content[] = [
                'name' => "{$this->member->present()->rankName} ({$this->member->clan_id}) - {$division}",
                'value' => "Rank History: " . $this->buildRankHistory($this->member)
            ];
        }

        if ($this->member->count()) {
            return [
                "embed" => [
                    'color' => 10181046,
                    'fields' => $this->content
                ]
            ];
        }

        return [
            'text' => "No results were found",
        ];
    }

    /**
     * @param $member
     * @return string|null
     */
    private function buildRankHistory($member)
    {
        $rankHistory = MemberHistory::where('member_id', $member->id)->with([
            'trackable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([Rank::class]);
            },
        ])->orderByDesc('created_at')->get();

        return PHP_EOL . "Rank History: {$rankHistory}";
    }
}
