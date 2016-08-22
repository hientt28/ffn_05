<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Team\TeamRepository;
use App\Http\Requests\TeamRequest;
use App\Services\FileUpload;

class TeamController extends Controller
{
    use FileUpload;
    private $teamRepository;
    private $countryRepository;
    public function __construct(TeamRepository $teamRepository, CountryRepository $countryRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = $this->teamRepository->paginate(config('common.paginate'));

        return view('admin.team.index', ['teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->countryRepository->lists('name', 'id');

        if (!$countries) {
            return redirect()->route('admin.teams.index')
                ->withErrors(['message' => trans('team.not_found')]);
        }

        return view('admin.team.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        $team = $request->only('name', 'description', 'country_id');

        if ($request->hasFile('logo')) {
            $fileName = $request->logo;
            $team['logo'] = $this->cloudder($fileName, config('common.path_cloud_team') . $request->name);
        }
        
        if (!$this->teamRepository->create($team)) {
            return redirect()->route('admin.teams.index')
                ->withErrors(['message' => trans('team.create_error')]);
        }

        return redirect()->route('admin.teams.index')->withSuccess(trans('message.team_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = $this->teamRepository->find($id);

        if (!$team) {
            return redirect()->route('admin.teams.index')
                ->withErrors(['message' => trans('team.not_found')]);
        }

        return view('admin.team.show', compact('team'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = $this->teamRepository->find($id);

        if (!$team) {
            return redirect()->route('admin.teams.index')
                ->withErrors(['message' => trans('team.not_found')]);
        }

        $countries = $this->countryRepository->lists('name', 'id');

        return view('admin.team.edit', compact('team', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        $team = $request->only('name', 'description', 'country_id');

        if ($request->hasFile('logo')){
            $fileName = $request->logo;
            $team['logo'] = $this->cloudder($fileName, config('common.path_cloud_team') . $request->name);
        }

        if (!$this->teamRepository->update($team, $id)) {
            return redirect()->route('admin.team.index')
                ->withErrors(['message' => trans('team.update_error')]);
        }

        return redirect()->route('admin.teams.index')->withSuccess(trans('message.team_create_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->teamRepository->delete($id);

        return redirect(route('admin.teams.index'))->withSucces(trans('message.delete_success'));
    }
}
