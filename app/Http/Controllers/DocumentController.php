<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller {

    public function show(Document $document)
    {
        if (!\request()->user()->isAdmin()) {
            abort(403, Response::HTTP_FORBIDDEN);
        }

        return \response(Storage::disk('s3')->get($document->file_name))->header('Content-Type', 'application/pdf');
    }
}
