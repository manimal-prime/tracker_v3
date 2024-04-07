<?php

namespace App\Transformers;

class DivisionBasicTransformer extends Transformer
{
    public function transform($item): array
    {
        return [
            'name' => $item->name,
            'slug' => $item->slug,
            'abbreviation' => $item->abbreviation,
            'description' => $item->description,
            'forum_app_id' => $item->forum_app_id,
            'members_count' => $item->members_count,
            'officers_channel' => $item->settings()->get('slack_channel'),
        ];
    }
}
