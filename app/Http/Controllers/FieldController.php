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

            $fields = $fields->map(function ($row) use ($subscriber_fields) {
                $s = $subscriber_fields->where('id', $row->id)->first();
                if ($s) return $s;

                return $row;
            });
        }

        return response()->json(['fields' => $fields, 'field_types' => FieldType::cases()]);
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
}
