<?php

namespace App\Http\Controllers\API\Project;

use App\Http\Requests\Comment\DeleteComment;
use App\Http\Requests\Comment\StoreComment;
use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Task;

class CommentController extends Controller
{
    public function store(StoreComment $request, Task $task)
    {
        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'task_id' => $task->id
        ]);

        return new CommentResource($comment);
    }

    public function destroy(DeleteComment $request, Task $task, Comment $comment)
    {
        $comment->delete();

        return new CommentResource($comment);
    }
}
