<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddMemberRequest;
use App\TeamLeaders;

class TeamLeaderController extends Controller
{
    public function addMember(AddMemberRequest $request)
    {
      $teamLeaders = TeamLeaders::forceCreate([
          'fullName' => $request->fullName,
          'contactNumber' => $request->contactNumber,
          'address' => $request->address,
          'municipality' => $request->municipality
        ]);
        return response($teamLeaders, 200);
    }

    public function getMember()
    {
      return TeamLeaders::all();
    }

    public function getMembersByMunicipality($municipality)
    {
      return TeamLeaders::where('municipality', '=', $municipality)->get();
    }
    public function editMember(Request $request, $id)
    {
      $teamLeader = TeamLeaders::find($id);
      $teamLeader->fullName = $request->fullName;
      $teamLeader->contactNumber = $request->contactNumber;
      $teamLeader->address = $request->address;
      $teamLeader->save();
    }
}
