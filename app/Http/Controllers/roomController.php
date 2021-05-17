<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\room;

class roomController extends Controller
{

    //add room
    public function addRoom(Request $request)
    {
        $this->validate(
            $request,
            [

                'name' => 'required',
                'idCategory' => 'required',
                'status' => 'required',

            ],
            [

                'name.required' => "You have not entered a room name",
                'idCategory.required' => "You have not entered a room type",
                'status.required' => "You have not entered room status",

            ]
        );

        $room = new room;
        // $room->link=$request->link;
        $room->name = $request->name;
        $room->idCategory = $request->idCategory;
        $room->Status = $request->status;
        $room->save();
        return redirect('addrRoom')->with('annoucement', 'room added successfully');
    }


    //get list
    public function room_list()
    {
        // dd(AUTH::user());
        // $roomList = DB::table('room__categories')->get();
        $roomList = room::all();
        // print_r($roomList);
        return view('admin.room.list', ['room' => $roomList]);
    }


    //delete
    public function delete($id)
    {

        $room = room::find($id);
        $room->delete();
        return redirect('Listofroom')->with('annoucement', 'Room deleted successfully');
    }

    public function ShowEditRoom($id)
    {
        // dd($id);die;
        $roomList = room::find($id);
        return view('admin.room.edit', ['room' => $roomList]);
    }

    public function EditRoom(Request $request, $id)
    {
        $this->validate(
            $request,
            [

                'name' => 'required',
                'idCategory' => 'required',
                'status' => 'required',

            ],
            [

                'name.required' => "You have not entered a room name",
                'idCategory.required' => "You have not entered a room type",
                'status.required' => "You have not entered room status",

            ]
        );

        $room = room::find($id);
        // $room->link=$request->link;
        $room->name = $request->name;
        $room->idCategory = $request->idCategory;
        $room->Status = $request->status;
        $room->save();
        return redirect('Listofroom')->with('annoucement', 'Successfully edited room information');
    }
}
