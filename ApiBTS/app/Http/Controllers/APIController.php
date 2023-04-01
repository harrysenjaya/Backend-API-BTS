<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Models\User;

class APIController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()
            ->json(['user' => $user]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('username', $request['username'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function getChecklist()
    {
        $checklist = Checklist::all();

        return response()
            ->json([
                'checklist' => $checklist,
            ]);
    }

    public function addChecklist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $checklist = Checklist::create(["name" => $request->name]);

        return response()
            ->json(['checklist' => $checklist]);
    }

    public function deleteChecklist(Request $request, $id)
    {
        $checklist = Checklist::find($id);
        if ($checklist == null) {
            return response()
                ->json(['message' => 'Checklist not found'], 401);
        }
        $checklist->delete();
        return response()
            ->json(['message' => 'Checklist deleted']);
    }

    public function getAllChecklistItem($id)
    {
        $checklistItem = ChecklistItem::with('checklist')->where('id_checklist', $id)->get();

        return response()
            ->json([
                'checklistItem' => $checklistItem,
            ]);
    }

    public function addChecklistItem(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $checklist = Checklist::find($id);
        if ($checklist == null) {
            return response()
                ->json(['message' => 'Checklist not found'], 401);
        }

        $checklistItem = ChecklistItem::create(["name" => $request->name, "id_checklist" => $id]);

        return response()
            ->json(['checklistItem' => $checklistItem]);
    }

    public function getChecklistItem($checklistId, $checklistItemId)
    {

        $checklistItem = ChecklistItem::with('checklist')->where('id_checklist', $checklistId)->where('id', $checklistItemId)->get();

        return response()
            ->json([
                'checklistItem' => $checklistItem,
            ]);
    }

    public function updateChecklistItem($checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::find($checklistItemId);
        if ($checklistItem == null) {
            return response()
                ->json(['message' => 'ChecklistItem not found'], 401);
        }
        
        $checklistItem->update(["id_checklist" => $checklistId]);
        return response()
            ->json([
                'checklistItem' => $checklistItem,
            ]);
    }

    public function deleteChecklistItem($checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::find($checklistItemId);
        if ($checklistItem == null) {
            return response()
                ->json(['message' => 'ChecklistItem not found'], 401);
        }
        $checklistItem->delete();
        return response()
            ->json(['message' => 'ChecklistItem deleted']);
    }

    public function renameChecklistItem(Request $request, $checklistId, $checklistItemId)
    {
        $checklistItem = ChecklistItem::find($checklistItemId);
        if ($checklistItem == null) {
            return response()
                ->json(['message' => 'ChecklistItem not found'], 401);
        }
        $checklistItem->update(["name" => $request->itemName]);
        return response()
            ->json([
                'checklistItem' => $checklistItem,
            ]);
    }
}
