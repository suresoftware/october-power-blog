<?php namespace SureSoftware\PowerBlog\Models;

use Model;
use SureSoftware\PinnacleProgramme\Models\Profile;

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
        'slug' => ''
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


    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $model->checkAndCreateSlugs($model);
        });

        self::updated(function($model){
            $model->checkAndCreateSlugs($model);
        });
    }

    public function checkAndCreateSlugs($model){
        if(!empty($model->slug)) return;

        //create an SEO friendly slug if possible
        $slug = Author::createSlug($model->name);

        //increment the slug if needed
        $increment = 1;
        while(Author::where('slug', $slug)->first()){
            if($increment == 1){
                $slug .= "-" . $increment;
            }
            $slug = substr($slug, 0, -(strlen((string)$increment)));
            $slug .= $increment;
        }

        //finally save the new slug
        $model->slug = $slug;
        $model->save();
    }

    /**
     * Create an authors slug
     *
     * @param $string
     * @return mixed|string
     */
    public static function createSlug($string){
        $string = strtolower($string); //lowercase
        $string = trim($string); //remove ending whitespace
        $string = str_replace(' ', '-', $string); //hyphenate spaces
        $string = preg_replace('/[^a-z0-9\-]/', '', $string); //remove special characters
        $string = preg_replace('/-+/', '-', $string); //remove double hyphens
        return $string;
    }

}
