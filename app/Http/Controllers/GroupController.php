<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Group;
use App\Company;

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
        return view('groups.index',compact('groups', 'companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $user = Auth::user();
        return view('groups.create',compact('groups','user'));
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
        $usersInGroup = DB::table('users')
                            ->join('groups_users', 'users.id', '=', 'groups_users.id_user')
                            ->where('groups_users.id_group', $group->id)
                            ->select('users.*')
                            ->get();

        $companies = Company::all();
        return view('groups.show',compact('group', 'companies','usersInGroup'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.edit',compact('group'));
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
        $group->save();
        
        return redirect()->route('groups.index')->with('status', 'Group editado con éxito.');
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
}
