<?php namespace SureSoftware\PowerBlog\Models;

use Model;

/**
 * Author Model
 */
class Author extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'suresoftware_powerblog_authors';

    public $rules = [
        'name' => 'required',
        'bio' => 'required',
    ];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];

    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'avatar' => 'System\Models\File'
    ];
    public $attachMany = [];

}
