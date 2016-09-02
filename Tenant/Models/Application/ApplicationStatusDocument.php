<?php namespace App\Modules\Tenant\Models\Application;

use App\Modules\Tenant\Models\Document;
use Illuminate\Database\Eloquent\Model;
use DB;

class ApplicationStatusDocument extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'application_status_documents';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'application_status_document_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['document_id', 'application_status_id', 'application_id'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the document associated with the client document.
     */
    public function document()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Document');
    }

    /**
     * Get documents attached to client.
     *
     * @return Collection
     */
    public function getApplicationDocuments($application_id)
    {
        $documents = ApplicationStatusDocument::with('document')->where('application_id', $application_id)->orderBy('application_status_document_id', 'desc')->get();
        return $documents;
    }

    /**
     * Add records to uploaded documents attached to client.
     *
     * @return Boolean
     */
    public function uploadDocument($application_id, $file, array $request, $status_id = 1)
    {
        DB::beginTransaction();

        try {
            $status_desc = Status::find($status_id)->description;

            $document = Document::create([
                'type' => $status_desc,
                'user_id' => current_tenant_id(),
                'name' => $file['fileName'],
                'shelf_location' => $file['pathName'],
                'description' => $request['description'], //Offer Letter
            ]);

            ApplicationStatusDocument::create([
                'document_id' => $document->document_id,
                'application_status_id' => $status_id,
                'application_id' => $application_id
            ]);
            DB::commit();
            return $document->document_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function getDocument($application_id, $status_id =1)
    {
        $document = ApplicationStatusDocument::join('documents', 'documents.document_id', '=', 'application_status_documents.document_id')
            ->where('application_id', $application_id)
            ->where('application_status_id', $status_id)
            ->first();
        return $document;
    }
}
