<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Taskss;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskCreated;



class TasksController extends Controller
{


    public function addTask(Request $request)
    {

        if (auth()->user()->role !== 1)
        {
            return response()->json(['error' => 'Sadece yöneticiler görev ekleyebilir.'], 403);
        }



         $task = Taskss::create([
            'task_time' => $request->task_time,

            'title' => $request->title,

            'subject' => $request->subject,

            'user_id' => $request->user_id,

            'status' => $request->status,
        ]);

        $user = User::find($request->user_id);

        Mail::to($user->email)->send(new TaskCreated($task));

        return response()->json(['message' => 'Görev başarıyla eklendi.'], 200);

    }



    public function updateTask(Request $request, $id)
    {
        $task = Taskss::findOrFail($id);

        if (auth()->user()->role === 1)
        {
            $task->update([
                'task_time' =>$request->filled('task_time') ? $request->task_time :$task->task_time,

                'title' => $request->filled('title') ? $request->title : $task->title,

                'subject' => $request->filled('subject') ? $request->subject :$task->subject,

                'status' => $request->filled('status') ? $request->status: $task->status,
            ]);

            return response()->json(['message' => 'Görev başarıyla güncellendi.'], 200);
        }



        else
        {

            if ($request->filled('status'))
            {

                $fillableFields = ['task_time', 'title', 'subject', 'user_id'];

                foreach ($fillableFields as $field)
                {
                    if ($request->filled($field))
                    {
                        return response()->json(['error' => 'Sadece yöneticiler tüm alanları güncelleyebilir.'], 403);
                    }
                }

                $task->update([
                    'status' => $request->status,
                ]);
                return response()->json(['message' => 'Görev statüsü başarıyla güncellendi.'], 200);
            }
            else
            {
                return response()->json(['error' => 'Sadece yöneticiler tüm alanları güncelleyebilir.'], 403);
            }
        }





    }





    public function softDelete($id)
    {

        $task = Taskss::find($id);

        if($task)
        {

            if (auth()->user()->role === 1)
            {
                $task->delete();

                return response()->json(['message' => 'Görev başarıyla silindi'], 200);

            }

            else
            {
                return response()->json(['error' => 'Sadece yöneticiler Silme İşlemi Yapabilir.'], 403);
            }



        }

        else
        {

            return response()->json(['error' => 'Görev bulunamadı'], 404);
        }

    }



    public function hardDelete($id)
    {

        $task = Taskss::withTrashed()->find($id);

        if($task)
        {

            if (auth()->user()->role === 1)
            {
                $task->forcedelete();

                return response()->json(['message' => 'Görev Geri Dönüşümsüz olarak başarıyla silindi'], 200);

            }

            else
            {
                return response()->json(['error' => 'Sadece yöneticiler Silme İşlemi Yapabilir.'], 403);
            }



        }

        else
        {

            return response()->json(['error' => 'Görev bulunamadı'], 404);
        }

    }














}
