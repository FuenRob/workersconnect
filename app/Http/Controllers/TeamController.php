<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Team;
use App\Company;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::latest()->paginate(5);
        $companies = Company::all();
        return view('teams.index',compact('teams', 'companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $user = Auth::user();
        return view('teams.create',compact('teams','user'));
    }

    /**
     * Created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = Auth::user();
        $idTeam = Team::create($request->all())->id;
        $dateNow = date("Y-m-d");
        DB::insert('INSERT INTO teams_users (id_team, id_user, is_manager, created_at, updated_at) values (?, ?, ?, ?, ?)', [$idTeam, $user->id, true, $dateNow, $dateNow]);
        
        return redirect()->route('teams.index')->with('status', 'Equipo creado con éxito.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        $usersInTeam = DB::table('users')
                            ->join('teams_users', 'users.id', '=', 'teams_users.id_user')
                            ->where('teams_users.id_team', $team->id)
                            ->select('users.*')
                            ->get();

        $companies = Company::all();
        return view('teams.show',compact('team', 'companies','usersInTeam'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        return view('teams.edit',compact('team'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $team = Team::find($id);
        $team->name = $request->get('name');
        $team->save();
        
        return redirect()->route('teams.index')->with('status', 'Equipo editado con éxito.');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
  
        return redirect()->route('teams.index')->with('status','Equipo eliminado');
    }
}
