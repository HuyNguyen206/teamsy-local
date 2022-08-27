<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    public function show(User $user, Document $document)
    {
        if ($user->id !== $document->user_id) {
            abort(403, Response::HTTP_FORBIDDEN);
        }

    }
}
