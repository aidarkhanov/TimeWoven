<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function respond(Request $request, string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();
        $invitation->update(['response' => $request->response]);

        return response()->json(['message' => 'Response updated successfully.']);
    }
}
