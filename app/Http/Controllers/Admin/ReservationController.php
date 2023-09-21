<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Table;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tables = Table::where('status','disponible')->get();
        return view('admin.reservations.create', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $request)
    {
        $table = Table::findorFail($request->table_id);

        if ($request->guest_number > $table->guest_number)
        {
            return back()->with('warning', 'Le nombres d\'invités doivent être inférieur ou égale au place dans la table disponible !');
        }

        $request_date = Carbon::parse($request->res_date);

        foreach ($table->reservations as $res)
        {
            if ($res->res_date->format('Y-m-d') == $request_date->format('Y-m-d'))
            {
                return back()->with('warning', 'Cette table est reservé pour cette date');
            }
        }

        $reservation = Reservation::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tel_number' => $request->tel_number,
            'res_date' => $request->res_date,
            'table_id' => $request->table_id,
            'guest_number' => $request->guest_number,
        ]);

        return to_route('admin.reservations.index')->with('success', 'Reservation créée avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $tables = Table::where('status','disponible')->get();

        return view('admin.reservations.edit', compact('tables','reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationStoreRequest $request, Reservation $reservation)
    {
        $table = Table::findorFail($request->table_id);
        if ($request->guest_number > $table->guest_number)
        {
            return back()->with('warning', 'Le nombres d\'invités doivent être inférieur ou égale au place dans la table disponible !');
        }

        $request_date = Carbon::parse($request->res_date);
        $reservations = $table->reservations()->where('id', '!=', $reservation->id)->get();

        foreach ($reservations as $res)
        {
            if ($res->res_date->format('Y-m-d') == $request_date->format('Y-m-d'))
            {
                return back()->with('warning', 'Cette table est reservé pour cette date');
            }
        }
        
        $reservation->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'tel_number' => $request->tel_number,
            'res_date' => $request->res_date,
            'table_id' => $request->table_id,
            'guest_number' => $request->guest_number,
        ]);

        return to_route('admin.reservations.index')->with('success', 'Reservation modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return to_route('admin.reservations.index')->with('danger', 'Reservation supprimée avec succès');
    }
}
