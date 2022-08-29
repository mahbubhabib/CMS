<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $fillable = [
        'parent_id','slug', 'title', 'content'
    ];

    protected $casts = [
        'parent_id' =>  'integer'
    ];
    protected $scoped = array();
    /**
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    //to get parent page of the page
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    //to get children of given page
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    public function newNestedSetQuery($excludeDeleted = true) {
        $builder = $this->newQuery($excludeDeleted)->orderBy($this->getQualifiedOrderColumnName());

        if ( $this->isScoped() ) {
          foreach($this->scoped as $scopeFld)
            $builder->where($scopeFld, '=', $this->$scopeFld);
        }

        return $builder;
      }


    public function getAncestorsAndSelf($columns = array('*')) {
        return $this->ancestorsAndSelf()->get($columns);
      }

      public function ancestorsAndSelf() {
        return $this->newNestedSetQuery()
                    ->where('slug', '<=', $this->getAttribute('slug'))
                    ->where('slug', '>=', $this->getAttribute('slug'));
      }

      public function getQualifiedOrderColumnName() {
        return $this->getTable() . '.' . $this->getOrderColumnName();
      }

      public function getOrderColumnName() {
        return is_null($this->orderColumn) ? 'slug' : null;
      }
      public function isScoped() {
        return !!(count($this->getScopedColumns()) > 0);
      }
      public function getScopedColumns() {
        return (array) $this->scoped;
      }
}
