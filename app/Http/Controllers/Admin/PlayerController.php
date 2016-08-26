<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Repositories\CountryRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\PositionRepository;
use App\Repositories\TeamRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;

class PlayerController extends Controller
{
    private $playerRepository;
    private $positionRepository;
    private $countryRepository;
    private $teamRepository;

    public function __construct(
        PlayerRepository $playerRepository,
        PositionRepository $positionRepository,
        CountryRepository $countryRepository,
        TeamRepository $teamRepository
    ) {
        $this->playerRepository = $playerRepository;
        $this->positionRepository = $positionRepository;
        $this->countryRepository = $countryRepository;
        $this->teamRepository = $teamRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = $this->playerRepository->paginate(config('common.paginate'));

        return view('admin.player.index', ['players' => $players]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = $this->positionRepository->lists('name', 'id');
        $countries = $this->countryRepository->lists('name', 'id');
        $teams = $this->teamRepository->lists('name', 'id');

        if (!$countries || !$positions || !$teams) {
            return redirect()->route('admin.players.index')
                ->withErrors(['message' => trans('player.not_data')]);
        }

        return view('admin.player.create', compact('positions', 'countries', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerRequest $request)
    {
        $player = $request->only('name', 'birthday', 'country_id', 'position_id', 'team_id');

        if (!$this->playerRepository->create($player)) {
            return redirect()->route('admin.players.index')
                ->withErrors(['message' => trans('player.not_create_player')]);
        }

        return redirect()->route('admin.players.index')->withSuccess(trans('message.player_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player = $this->playerRepository->find($id);

        if (!$player) {
            return redirect()->route('admin.players.index')
                ->withErrors(['message' => trans('player.not_found')]);
        }

        return view('admin.player.show', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $player = $this->playerRepository->find($id);

        if (!$player) {
            return redirect()->route('admin.players.index')
                ->withErrors(['message' => trans('player.not_found')]);
        }

        $positions = $this->positionRepository->lists('name', 'id');
        $countries = $this->countryRepository->lists('name', 'id');
        $teams = $this->teamRepository->lists('name', 'id');

        if (!$countries || !$positions || !$teams) {
            return redirect()->route('admin.players.index')
                ->withErrors(['message' => trans('player.not_data')]);
        }

        return view('admin.player.edit', compact('positions', 'countries', 'teams', 'player'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerRequest $request, $id)
    {
        $player = $request->only('name', 'birthday', 'country_id', 'position_id', 'team_id');

        if (!$this->playerRepository->update($player, $id)) {
            return redirect()->route('admin.players.index')
                ->withErrors(['message' => trans('player.not_update_player')]);
        }
        
        return redirect()->route('admin.players.index')->withSuccess(trans('message.player_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->playerRepository->delete($id);

        return redirect(route('admin.players.index'))->withSucces(trans('message.delete_success'));
    }
}
