<?php

namespace App\Http\Controllers;

use App\Enums\SubscriberStatus;
use App\Http\Requests\StoreSubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Models\Field;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //Should use pagination here
        $subscribers = Subscriber::all();

        return response()->json(['subscribers' => $subscribers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubscriberRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreSubscriberRequest $request, $id = null)
    {
        $subscriber = Subscriber::updateOrCreate(['id' => $id], $request->validated());


        if ($fields = $request->fields) {

            $fields_to_create = collect($fields)->where('id',null)->whereNotNull('value')->toArray();
            $fields = collect($fields)->whereNotNull('id')->whereNotNull('value');
            $created_fields = Field::createFields($fields_to_create);

            $existing_fields = $fields->merge($created_fields)->keyBy('id')->columns('value');

            $subscriber->fields()->sync($existing_fields);
        }

        $subscriber->loadMissing('fields');

        return response()->json(['status' => true, 'subscriber' => $subscriber]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Subscriber $subscriber)
    {
        $subscriber->loadMissing('fields');

        return response()->json(['status' => true, 'subscriber' => $subscriber]);
    }

    public function statuses() {

        $status = SubscriberStatus::cases();

        return response()->json(['statuses' => $status]);
    }
}
