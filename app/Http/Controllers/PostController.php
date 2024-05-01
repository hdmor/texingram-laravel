<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        $stored_file_paths = [];
        try {
            $post = Post::query()->create($data);

            /** @var UploadedFile[] $attachments */
            $attachments = $data['attachments'] ?? [];
            foreach ($attachments as $file) {
                $path = $file->store("attachments/{$post->getAttribute('id')}", 'public');
                $stored_file_paths[] = $path;
                PostAttachment::query()->create([
                    'post_id' => $post->getAttribute('id'),
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => auth()->user()->getAuthIdentifier()
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            foreach ($stored_file_paths as $stored_file_path) {
                Storage::disk('public')->delete($stored_file_path);
            }
            DB::rollBack();
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        $data = $request->validated();
        DB::beginTransaction();
        $stored_file_paths = [];
        try {
            $post->update($data);

            $deletedAttachments = $data['deletedAttachments'] ?? [];
            $post_attachments = PostAttachment::query()->where('post_id', $post->getAttribute('id'))->whereIn('id', $deletedAttachments)->get();
            foreach ($post_attachments as $attachment) {
                $attachment->delete();
            }

            /** @var UploadedFile[] $attachments */
            $attachments = $data['attachments'] ?? [];
            foreach ($attachments as $file) {
                $path = $file->store("attachments/{$post->getAttribute('id')}", 'public');
                $stored_file_paths[] = $path;
                PostAttachment::query()->create([
                    'post_id' => $post->getAttribute('id'),
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'created_by' => auth()->user()->getAuthIdentifier()
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            foreach ($stored_file_paths as $stored_file_path) {
                Storage::disk('public')->delete($stored_file_path);
            }
            DB::rollBack();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->getAttribute('user_id') !== auth()->user()->getAuthIdentifier())
            abort(403);
        else {
            $post->delete();
            return back();
        }
    }
}
