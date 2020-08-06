<?php

namespace Avart\Forms\Controllers;

use App\Http\Controllers\Controller;
use Avart\Forms\Models\Field;
use Avart\Forms\Models\Type;
use Illuminate\Contracts\View\View;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        return view('forms::index', ['fields' => Field::all(), 'types' => Type::all()]);
    }
}
