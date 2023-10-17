<?php

namespace App\Actions;

use App\Contracts\DeletesMembers;
use App\Models\Member;
use App\Models\Archive;
use App\Models\Participant;
use Illuminate\Support\Facades\DB;

class DeleteMember implements DeletesMembers
{
    /**
     * Delete the given user.
     */
    public function delete(Member $member): void
    {

        $archive = new Archive();

        $archive->archivable()->associate($member);

        DB::transaction(function () use ($member, $archive) {
            $member->participants->each(function (Participant $participant) {
                $participant->member()->dissociate();
            });
            if($member->token){
                $member->token->delete();
            }
            if($member->user){
                $member->user->delete();
            }
            $member->delete();
            $archive->save();
        });
    }
}
