<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Perm;
use App\Models\Job;
use App\Http\Requests\JobRequest;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function permissions(): array
    {
        return [
            'index' => Perm::JOBS_VIEW_ALL,
            'show' => Perm::JOBS_VIEW_ALL,
            'destroy' => Perm::JOBS_DELETE_QUEUE,
            'destroyAll' => Perm::JOBS_DELETE_QUEUE,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param  JobRequest  $request
     * @return JsonResponse
     */
    public function index(JobRequest $request): JsonResponse
    {
        $query = Job::query();

        // Search
        if ($request->has('search') && $request->exists('columns')) {
            foreach ($request->columns as $column) {
                $query->orWhere($column, 'LIKE', $request->search.'%');
            }
        }

        // Order
        if ($request->has('sortColumn')) {
            $query->orderBy($request->sortColumn, $request->sortOrder === 'descending' ? 'desc' : 'asc');
        }

        $list = $query->paginate();

        return response()->json($list);
    }

    /**
     * Display the specified resource.
     *
     * @param  Job  $job
     * @return JsonResponse
     */
    public function show(Job $job): JsonResponse
    {
        $job = Job::findOrFail($job->id);

        return response()->json([
            'message' => __('app.jobs.show'),
            'job' => $job,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Job  $job
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Job $job): JsonResponse
    {
        $job->delete();

        return response()->json([
            'message' => __('app.jobs.destroy'),
        ]);
    }

    /**
     * Remove resource from storage.
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroyAll(): JsonResponse
    {
        $count = Job::query()->delete();

        return response()->json([
            'message' => __('app.jobs.destroy_all').': '.$count,
        ]);
    }
}
