<?php namespace SureSoftware\PowerBlog\Models;

use Model;

/**
 * Setting Model
 */
class Setting extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'suresoftware_powerblog_settings';

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
    public $attachOne = [];
    public $attachMany = [];
}
