<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\reservation;
use Illuminate\Support\Facades\Validator;

class reservationController extends Controller
{
    public function insertreservation(Request $request)
    {
        // print_r($request);
        $reservation = new reservation();
        $validatedData = Validator::make($request->all(), [
            'title' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:reservations',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'phone' => 'required|unique:reservations',
            'troom' => 'required',
            'bed' => 'required',
            'nroom' => 'required',
            'meal' => 'required',
            'cin' => 'required',
            'cout' => 'required',

        ]);
        if ($validatedData->fails()) {
            // return json_encode(array(
            //     "statusCode" => 201
            // ));
            return redirect('/error')
                ->withErrors($validatedData)
                ->withInput();
        } else {

            $reservation::create($request->all());
            return json_encode(array(
                "statusCode" => 200
            ));
        }
    }
}
