<?php namespace App\Modules\Tenant\Models\Institute;

use App\Modules\Tenant\Models\Document;
use Illuminate\Database\Eloquent\Model;
use DB;

class InstituteDocument extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'institute_document';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'institute_document_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['institution_id', 'document_id', 'description'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the document associated with the institute document.
     */
    public function document()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Document');
    }

    /**
     * Get documents attached to institute.
     *
     * @return Collection
     */
    public function getInstituteDocuments($institution_id)
    {
        $documents = InstituteDocument::with('document')->where('institution_id', $institution_id)->orderBy('institute_document_id', 'desc')->get();
        return $documents;
    }

    /**
     * Add records to uploaded documents attached to institute.
     *
     * @return Boolean
     */
    public function uploadDocument($institution_id, $file, array $request)
    {
        DB::beginTransaction();

        try {
            $document = Document::create([
                'type' => $request['type'],
                'user_id' => current_tenant_id(),
                'name' => $file['fileName'],
                'shelf_location' => $file['pathName'],
                'description' => $request['description'],
            ]);

            $institute_document_id = InstituteDocument::create([
                'document_id' => $document->document_id,
                'status_id' => 1, //change later ??
                'institution_id' => $institution_id
            ]);
            DB::commit();
            return $institute_document_id->institute_document_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }
}
