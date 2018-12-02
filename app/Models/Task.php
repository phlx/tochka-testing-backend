<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task
 * @package App\Models
 *
 * @property $title         Заголовок
 * @property $date          Дата выполнения
 * @property $author        Автор
 * @property $status        Статус
 * @property $description   Описание
 */
class Task extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'date',
        'author',
        'status',
        'description',
    ];
}
