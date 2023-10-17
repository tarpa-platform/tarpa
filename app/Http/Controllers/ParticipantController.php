<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParticipantRequest;
use App\Http\Requests\UpdateParticipantRequest;
use App\Models\Member;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use App\Models\Participant;
use App\Models\SignupToken;
use App\Models\Status;
use App\Models\Timepoint;
use App\Notifications\ParticipantAssigned;
use Inertia\Inertia;
use Inertia\Response;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        $participants = QueryBuilder::for(Participant::class)
            ->allowedFilters([
                AllowedFilter::scope('mine', 'assignedToUser'),
            ])
            ->defaultSort('canonical_id')
            ->allowedSorts([
                AllowedSort::field('name'),
                AllowedSort::field('id', 'canonical_id')
            ])
            ->with(['member', 'status'])
            ->get();

        return Inertia::render('Participant/Index', ['participants' => $participants]);

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
    public function store(StoreParticipantRequest $request)
    {

        $validated = $request->safe()->only(['name', 'email_address', 'canonical_id', 'member_id', 'timpepoint_id', 'status_id']);

        $participant = Participant::create($validated);

		$token = SignupToken::create([
			'signup_role' => ''
		]);

		$token->registrant()->associate($participant)->save();

        return redirect()->action([ParticipantController::class, 'show'], $participant);
    }

    /**
     * Display the specified resource.
     */
    public function show(Participant $participant): Response
    {
        $statuses = Status::all();

        $timepoints = Timepoint::all();

        $members = Member::assignable()->get();

        return Inertia::render('Participant/Edit', [
            "participant" => $participant,
            "statuses" => $statuses,
            "timepoints" => $timepoints,
            "members" => $members
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParticipantRequest $request, Participant $participant)
    {
        $participant->fill($request->validated());

        $participant->save();

        if($participant->wasChanged('member_id') && $participant->member_id){
            $participant->refresh();
            $participant->member->notify(new ParticipantAssigned($participant, $participant->member, $request->user()->linkable));
        }

        return redirect()->action([ParticipantController::class, 'show'], $participant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Participant $participant)
    {
        //
    }
}
