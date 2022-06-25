<?php

namespace App\Http\Controllers;

use App\Enums\FieldType;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;
use App\Models\Field;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //Should be paginated but for the test app I'm rendering all fields
        $fields = Field::all();


        if ($request->subscriber_id) {

            $subscriber_fields = Subscriber::find($request->subscriber_id)->fields->toArray();
            $subscriber_fields = collect($subscriber_fields)->columns(['id', 'value', 'type', 'title']);
//            dd(collect($subscriber_fields)->columns(['id', 'value', 'type', 'title'])->concat(collect($fields->toArray())->columns(['id', 'value', 'type', 'title'])));

            $fields = $fields->map(function ($row) use ($subscriber_fields) {
                $s = $subscriber_fields->where('id', $row->id)->first();
                if ($s) return $s;

                return $row;
            });
        }

        return response()->json(['fields' => $fields, 'field_types' => FieldType::cases()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreFieldRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFieldRequest $request, $id = null)
    {
        $field = Field::updateOrCreate(['id' => $id], $request->validated());

        return response()->json(['status' => true, 'field' => $field]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateFieldRequest $request
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldRequest $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        //
    }
}
