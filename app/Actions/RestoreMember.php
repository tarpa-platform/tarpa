<?php

namespace App\Actions;

use App\Contracts\DeletesMembers;
use App\Contracts\RestoresMembers;
use App\Models\Member;
use App\Models\Archive;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class RestoreMember implements RestoresMembers
{
    /**
     * Delete the given user.
     */
    public function restore(Member $member): void
    {
        $member->deleted_at = null;

        DB::transaction(function () use ($member) {
            $member->archive()->delete();
            $member->save();
        });
    }
}
