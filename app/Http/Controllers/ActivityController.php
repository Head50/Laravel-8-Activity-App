<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function create(Request $request)
    {
        $user = $this->userdata();
        $activity = Activity::create([
            'activity' => $request->activity,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Activity successfully create',
            'activity' => $activity
        ], 201);
    }

    public function allActivity()
    {
        $user = $this->userdata();
        return response()->json([
            'user_name' => $user->name,
            'activity' => $user->activities()->get()
        ], 201);

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activityId' => 'required',
            'activity' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = $this->userdata();
        $activity = $user->activities()->get()->find($request->activityId);
        if($activity == null){
            return response()->json([
                'message' => 'Activity not found',
            ], 404);
        }
        $activity->activity = $request->activity;
        $activity->save();
        return response()->json([
            'message' => 'update successfully',
            'activity' => $activity
        ], 201);
    }

    public function delete(Request $request)
    {
        $user = $this->userdata();
        $activity = $user->activities()->get()->find($request->activityId);
        if($activity == null){
            return response()->json([
                'message' => 'Activity not found',
            ], 404);
        }
        $activity->delete();
        return response()->json([
            'message' => 'delete successfully'
        ], 201);
    }

    protected function userdata(){
        $user = auth()->user();
        return $user;
    }
}
