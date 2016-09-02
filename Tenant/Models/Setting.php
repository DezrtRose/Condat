<?php
namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    protected $table = "settings";

    protected $fillable = ['name', 'value'];

    protected $primaryKey = "name";

    protected $connection = 'tenant';


    function get($name)
    {
        return $this->where('name', $name)->first();
    }

    function scopeFix($query)
    {
        return $query->where('name', 'fix');
    }

    function scopeCompany($query)
    {
        return $query->where('name', 'company');
    }

    function scopeSetting($query)
    {
        return $query->where('name', 'userSetting');
    }

    function scopeBank($query)
    {
        return $query->where('name', 'bank');
    }

    function getCompany()
    {
        $company = $this->company()->first(['value']);

        return isset($company->value) ? $company->value : null;
    }

    function getSetting()
    {
        $setting = $this->setting()->first(['value']);

        return isset($setting->value) ? $setting->value : null;
    }

    function getBankDetails()
    {
        $bank = $this->bank()->first(['value']);

        return isset($bank->value) ? $bank->value : null;
    }

    function saveSetup($name = '', $value = '')
    {
        $setup = Setting::firstOrNew(['name' => $name]);
        $setup->value = $value;
        $setup->save();
    }

    function addOrUpdate(array $data = array(),$group = NULL)
    {
        if (!empty($data)):
            if(is_null($group)){
                foreach ($data as $key => $value) {

                $setting = Setting::firstOrNew(['name' => $key]);
              
                $setting->value = $value;
                
                $setting->save();
            }

            }else{
                foreach ($data as $key => $value) {

                $setting = Setting::firstOrNew(['name' => $group]);
                if (is_array($value) || is_object($value)) {
                    $setting->value = serialize($value);
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            }

            }
        endif;
    }

    function getValueAttribute($value)
    {
        $data = @unserialize($value);
        if ($data !== false) {
            return $data;
        } else {
            return $value;
        }
    }

    public function getSupportSetting() {
        $support_smtp = Setting::where('name', 'support_smtp')->first();
        return ($support_smtp) ? ($support_smtp->value) : null;
    }

}
