<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Holiday;
use App\HolidayType;
use App\HolidayManager;
use App\User;
use App\Mail\HolidayPeticion;
use App\Mail\HolidayPeticionManager;


class TeamsHolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays = Holiday::all();
        $users = User::all();
        $types = HolidayType::all();
        return view('holidays.index',compact('holidays', 'users', 'types'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $user = Auth::user();
        $types = HolidayType::all();
        return view('holidays.create',compact('holidays','user', 'types'));
    }

    /**
     * Created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'start' => 'required',
            'finish' => 'required',
            'hidden-reponsable' => 'required'
        ]);

        $user = Auth::user();

        $idHoliday = Holiday::create([
            'id_company' => $request['id_company'],
            'id_team' => 0,
            'id_user' => $user->id,
            'id_type' => $request['id_type'],
            'start' => date("Y-m-d", strtotime($request['start'])),
            'finish' => date("Y-m-d", strtotime($request['finish']))
        ])->id;

        $responsables = explode(',',$request['hidden-reponsable']);
        foreach($responsables as $responsable){
            $userResponsables = DB::table('users')->select('id','name')->where('email',$responsable)->get();

            foreach($userResponsables as $userResponsable){
                DB::table('teams_holidays_managers')->insert([
                    'id_company' => $user->id_company,
                    'id_team_holiday' => $idHoliday,
                    'id_user' => $userResponsable->id,
                    'accepted' => false
                ]);

                $userManager = User::find($userResponsable->id);
                // Mail for person who accepts holidays
                $data = array(
                    'url'=>"http://localhost/holidays/".$idHoliday,
                    'userRequest' => $user->name
                );
                Mail::to($userManager->email)->send(new HolidayPeticionManager($data));
            }
        }

        // Mail for person requesting holidays
        $data = array('url'=>"http://localhost/holidays/".$idHoliday);
        Mail::to($user->email)->send(new HolidayPeticion($data));
          
        return redirect()->route('holidays.index')->with('status', 'Vacaciones registradas con éxito.');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        $user = Auth::user();
        $types = HolidayType::all();
        $userResponsables = DB::table('users')
                                ->join('teams_holidays_managers', 'teams_holidays_managers.id_user', '=', 'users.id')
                                ->select('name','users.id','teams_holidays_managers.accepted')->where('id_team_holiday',$holiday->id)->get();

        return view('holidays.show',compact('holiday', 'userResponsables', 'types', 'user'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('holidays.edit',compact('holiday'));
    }
  
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'start' => 'required',
            'finish' => 'required'
        ]);

        $holiday = Holiday::find($id);
        $holiday->start = $request->get('start');
        $holiday->finish = $request->get('finish');
        $holiday->save();
        
        return redirect()->route('holidays.index')->with('status', 'Equipo editado con éxito.');
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
  
        return redirect()->route('holidays.index')->with('status','Vacaciones borradas');
    }

    public function accept($id)
    {

        $user = Auth::user();
        $userFound = DB::table('teams_holidays_managers')->where('id_user', $user->id)->count();

        if($userFound > 0){
            $result = DB::table('teams_holidays_managers')->where('id_user', $user->id)->where('id_team_holiday', $id)->update(['accepted' => true]);
            if($result){
                $holiday = Holiday::find($id);
                $holiday->status = "accepted";
                $holiday->save();

                return redirect()->route('holidays.show', ['holiday' => $id])->with('status', 'Petición de vacaciones aceptada.');
            }else{
                return redirect()->route('holidays.show', ['holiday' => $id])->with('status', 'No se ha podido actualizar el estado de la petición.');
            }
        }else{
            return redirect()->route('holidays.show', ['holiday' => $id])->with('status', 'No tiene permisos para hacer la siguiente acción.');
        }
    }

    public function decline($id)
    {
        $user = Auth::user();
        $userFound = DB::table('teams_holidays_managers')->where('id_user', $user->id)->count();

        if($userFound > 0){
            $holiday = Holiday::find($id);
            $holiday->status = "declined";
            $holiday->save();

            return redirect()->route('holidays.show', ['holiday' => $id])->with('status', 'Petición de vacaciones rechazada.');
        }else{
            return redirect()->route('holidays.show', ['holiday' => $id])->with('status', 'No tiene permisos para hacer la siguiente acción.');
        }
    }
}
