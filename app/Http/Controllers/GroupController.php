<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Group;
use App\Company;
use App\Team;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::latest()->paginate(5);
        $companies = Company::all();
        $teams = Team::all();
        return view('groups.index',compact('groups', 'companies', 'teams'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $user = Auth::user();
        $teams = Team::all();
        return view('groups.create',compact('groups', 'user', 'teams'));
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
        $idGroup = Group::create($request->all())->id;
        $dateNow = date("Y-m-d");
        DB::insert('INSERT INTO groups_users (id_group, id_user, is_manager, created_at, updated_at) values (?, ?, ?, ?, ?)', [$idGroup, $user->id, true, $dateNow, $dateNow]);
        
        return redirect()->route('groups.index')->with('status', 'Grupo creado con éxito.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $user = Auth::user();
        $usersInGroup = DB::table('users')
                            ->join('groups_users', 'users.id', '=', 'groups_users.id_user')
                            ->where('groups_users.id_group', $group->id)
                            ->select('users.*')
                            ->get();
        $userFollowGroup = $this->getUserFollowGroup($user->id, $group->id);
        $companies = Company::all();
        $teams = Team::all();
        return view('groups.show',compact('group', 'companies', 'usersInGroup', 'userFollowGroup', 'teams'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        $teams = Team::all();
        return view('groups.edit',compact('group', 'teams'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $group = Group::find($id);
        $group->name = $request->get('name');
        $group->description = $request->get('description');
        $group->id_team = $request->get('id_team');
        $group->save();
        
        return redirect()->route('groups.index')->with('status', 'Grupo editado con éxito.');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();
  
        return redirect()->route('groups.index')->with('status','Group eliminado');
    }

    /**
     * Follow the group
     *
     * @param  id_group $id
     * @return \Illuminate\Http\Response
     */
    public function followGroup($id){
        $user = Auth::user();
        $dateNow = date("Y-m-d");
        DB::insert('INSERT INTO groups_users (id_group, id_user, is_manager, created_at, updated_at) values (?, ?, ?, ?, ?)', [$id, $user->id, false, $dateNow, $dateNow]);
        return redirect()->route('groups.show', ['id_company' => $id]);
    }

    /**
     * Unfollow the group
     *
     * @param  id_group $id
     * @return \Illuminate\Http\Response
     */
    public function unfollowGroup($id){
        $user = Auth::user();
        DB::table('groups_users')->where('id_group', '=', $id)->where('id_user', '=', $user->id)->delete();
        return redirect()->route('groups.show', ['id_company' => $id]);
    }

    /**
     * Get users follow the group
     *
     * @param  id_group $id
     * @return \Illuminate\Http\Response
     */
    public function getUserFollowGroup($id_user, $id_group){
        $id_user = DB::table('groups_users')
                    ->where('groups_users.id_group', $id_group)
                    ->where('groups_users.id_user', $id_user)
                    ->select('groups_users.id_user')
                    ->get();
        if(count($id_user) > 0)
            return true;
        else
            return false;
    }
}
