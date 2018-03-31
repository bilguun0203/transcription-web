<?php

namespace App\Http\Controllers;

use App\Rules\TranscriptionRule;
use App\TaskEdit;
use App\TaskTranscribed;
use Illuminate\Http\Request;

class TaskEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskEdit = new TaskEdit();
        return redirect()->route('edit.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param TaskEdit $taskEdit
     * @return void
     */
    public function show(TaskEdit $taskEdit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TaskEdit $taskEdit
     * @return void
     */
    public function edit(TaskEdit $taskEdit)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param TaskEdit $taskEdit
     * @return TaskEdit
     */
    public function update(Request $request, TaskEdit $taskEdit)
    {
        $request->validate([
            'transcription' => ['required', 'max:5000', new TranscriptionRule],
        ]);
        $taskEdit->update($request->all());
        return $taskEdit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TaskEdit $task_edit
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(TaskEdit $taskEdit)
    {
        $taskEdit->delete();
        return response()->json(null, 204);
    }
}
