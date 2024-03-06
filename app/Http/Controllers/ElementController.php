<?php

namespace App\Http\Controllers;

use App\Models\Element;
use Illuminate\Http\Request;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $element = Element::all();
        return response()->json($element);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $element = new Element;
        $element->element_name = $request->element_name;
        $element->save();
        $data = [
            'message' => 'Element created successfully',
            'element' => $element
        ];
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Element $element)
    {
        //
        return response()->json($element);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Element $element)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Element $element)
    {
        //
        $element->element_name = $request->element_name;
        $element->save();
        $data = [
            'message' => 'Element updated successfully',
            'element' => $element
        ];
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Element $element)
    {
        //
        $element->delete();
        $data = [
            'message' => 'Element deleted successfully',
            'element' => $element
        ];
        return response()->json($data);
    }
}
