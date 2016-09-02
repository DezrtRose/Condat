<?php namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'document_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type', 'user_id', 'name', 'shelf_location', 'description'];


}
