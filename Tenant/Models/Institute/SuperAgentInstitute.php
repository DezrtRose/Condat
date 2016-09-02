<?php namespace App\Modules\Tenant\Models\Institute;

use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Commission;
use Illuminate\Database\Eloquent\Model;
use DB;

class SuperAgentInstitute extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'superagent_institutes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'superagent_institute_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['agents_id', 'institute_id', 'commissions_id'];

    /**
     * Disable default timestamp
     *
     * @var boolean
     */
    public $timestamps = false;

    /*
     * Add super agent
     * Output id
     */
    function add($institution_id, array $request)
    {
        DB::beginTransaction();

        try {
            $commission = Commission::create([
                'commission_percent' => $request['commission_percent'],
                'description' => 'Super Agent'
            ]);

            $super_agent = SuperAgentInstitute::create([
                'agents_id' => $request['agent_id'],
                'institute_id' => $institution_id,
                'commissions_id' => $commission->commission_id
            ]);
            DB::commit();
            return $super_agent->superagent_institute_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    function getDetails($institute_id)
    {
        $super_agents = SuperAgentInstitute::leftJoin('agents', 'agents.agent_id', '=', 'superagent_institutes.agents_id')
            ->leftJoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->leftJoin('commissions', 'superagent_institutes.commissions_id', '=', 'commissions.commission_id')
            ->select(['commissions.commission_percent', 'companies.name', 'agents.agent_id'])
            ->where('superagent_institutes.institute_id', $institute_id)
            ->get();
        return $super_agents;
    }
}
