<?php namespace App\Modules\Tenant\Models\Client;

use App\Modules\Tenant\Models\Notes;
use Illuminate\Database\Eloquent\Model;
use DB;


class ClientNotes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'client_notes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['note_id', 'client_id'];

    public $timestamps = false;

    public function notes()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Notes');
    }


    public function getAll($client_id, $remainders_only = false)
    {
        $notes = ClientNotes::join('notes', 'notes.notes_id', '=', 'client_notes.note_id')
            ->select('notes.*')
            ->orderBy('notes_id', 'desc')
            ->where('client_notes.client_id', $client_id);

        if($remainders_only)
            $notes = $notes->where('remind', 1);

        $notes = $notes->get();
        return $notes;
    }

    public function add($client_id, array $request)
    {
        $notes = Notes::create([
            'added_by_user_id' => current_tenant_id(),
            'description' => $request['description'],
            'remind' => (isset($request['remind'])) ? 1 : 0,
            'reminder_date' =>  (isset($request['remind'])) ? insert_dateformat($request['reminder_date']) : null,
        ]);

        ClientNotes::create([
            'note_id' => $notes->notes_id,
            'client_id' => $client_id
        ]);
        return $notes->notes_id;
    }

    public function deleteNote($note_id)
    {
        Notes::destroy($note_id);
        $client_notes = ClientNotes::where('note_id', $note_id)->first()->delete();
        if (!empty($client_notes))
            return $client_notes->client_id;
        else
            dd('Something went wrong');

    }


}

