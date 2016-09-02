<?php namespace App\Modules\Tenant\Models\Client;

use App\Modules\Tenant\Models\Document;
use Illuminate\Database\Eloquent\Model;
use DB;

class ClientDocument extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'client_documents';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'client_document_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['document_id', 'status_id', 'client_id'];

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
    public function getClientDocuments($client_id)
    {
        $documents = ClientDocument::with('document')->where('client_id', $client_id)->orderBy('client_document_id', 'desc')->get();
        return $documents;
    }

    /**
     * Add records to uploaded documents attached to client.
     *
     * @return Boolean
     */
    public function uploadDocument($client_id, $file, array $request)
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

            $client_document_id = ClientDocument::create([
                'document_id' => $document->document_id,
                'status_id' => 1, //change later ??
                'client_id' => $client_id
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
}
