<?php

namespace App\Http\Controllers;

use App\Contracts\DeletesMembers;
use App\Contracts\RestoresMembers;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Models\SignupToken;
use App\Policies\MemberPolicy;
use Illuminate\Auth\Access\Response as AccessResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $members = Member::all();

        return Inertia::render('Member/Index', ['members' => $members]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $validated = $request->safe()->only(['name', 'email_address', 'is_assignable', 'role']);

        $member = Member::create($validated);

		$token = SignupToken::create([
			'signup_role' => $validated['role']
		]);

		$token->registrant()->associate($member)->save();

        /**
         * TODO: Send Notification
         */

        return redirect()->action([MemberController::class, 'show'], $member);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member): Response
    {

        return Inertia::render($member->resolve()['view'], [$member->resolve()['data'] => $member]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, Member $member)
    {
        $member->fill($request->validated());

        $member->save();

        return back()->with('flash.success', [
            'title' => 'Team Member Updated',
            'message' => 'The team member was successfully updated.'
        ]);;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Member $member)
    {
        $this->authorize('delete', Member::class);

        app(DeletesMembers::class)->delete(
            $member
        );

        return redirect()->action([MemberController::class, 'index'])->with('flash.success', [
            'title' => 'Team Member Deleted',
            'message' => 'The team member was deleted successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function restore(Member $member)
    {
        $this->authorize('restore', Member::class);

        app(RestoresMembers::class)->restore(
            $member
        );

        return redirect()->action([MemberController::class, 'show'], $member)->with('flash.success', [
            'title' => 'Team Member Restored',
            'message' => 'The team member was restored successfully.'
        ]);
    }
}
