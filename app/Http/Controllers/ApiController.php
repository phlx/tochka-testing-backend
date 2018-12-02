<?php namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * @param int $count
     * @return array
     */
    public function regenerate(int $count = 1000): array
    {
        if (env('DB_CONNECTION') === 'sqlite') {
            $path = database_path('database.sqlite');
            if (file_exists($path)) {
                unlink($path);
            }
            file_put_contents($path, '');
        }
        $refresh = console('migrate:refresh');
        $generate = console('generate:tasks', ['--count' => $count]);
        return compact('refresh', 'generate');
    }

    /**
     * @param int $limit
     * @return int
     */
    public function pages(int $limit): int
    {
        return (int) ceil(Task::query()->count(['id']) / $limit);
    }

    /**
     * @param Request $request
     * @param int $limit
     * @param int $page
     * @return Task[]|Collection
     */
    public function paginated(Request $request, int $limit, int $page): Collection
    {
        $fields = explode(',', $request->get('fields', 'id,title,date,author,status'));

        return Task::query()
            ->orderBy('id', 'asc')
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get($fields);
    }

    /**
     * @param Request $request
     * @return Task[]|Collection
     */
    public function all(Request $request): Collection
    {
        $fields = explode(',', $request->get('fields', 'id,title,date,author,status'));

        return Task::all($fields);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Task|Model
     */
    public function one(Request $request, int $id): Task
    {
        $fields = explode(',', $request->get('fields', 'id,title,date,author,status,description'));

        return Task::query()->where('id', $id)->first($fields);
    }

    /**
     * @param Request $request
     * @param string $filter
     * @return Collection
     */
    public function filter(Request $request, string $filter): Collection
    {
        $fields = explode(',', $request->get('fields', 'id,title,date,author,status,description'));

        $that = "%{$filter}%";
        return Task::query()
            ->orWhere('title', 'like', $that)
            ->orWhere('author', 'like', $that)
            ->orWhere('description', 'like', $that)
            ->get($fields);
    }
}
