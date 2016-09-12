<?php namespace App\Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $guard = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['given_name', 'surname', 'username', 'password', 'email', 'status',
        'role', 'remember_token', 'title', 'added_by_users_id', 'activation_key'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function view($id = null)
    {
        $results = DB::select('select * from users where id = ?', array($id));
        return $results;

    }

    function redirectIfValid($user)
    {
        if ($user->status == 0) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has not been activated.');
        } elseif ($user->status == 2) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has been suspended.');
        } elseif ($user->status == 3) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has been permanently blocked.');
        }
        return redirect('dashboard');
    }

    /*
     * Add user info
     * Output user id
     */
    function add(array $request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $request['username'],
                'given_name' => $request['given_name'],
                'surname' => $request['surname'],
                'email' => $request['email'],
                'title' => $request['title'],
                'role' => $request['role'],
                'status' => 1, //activated
                'added_by_users_id' => \Auth::user()->id
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

        if ($user) return $user->id;
        else return false;
    }

    /*
     * Update user info
     * Output boolean
     */
    function edit(array $request, $user_id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($user_id);
            $user->username = $request['username'];
            $user->given_name = $request['given_name'];
            $user->surname = $request['surname'];
            $user->email = $request['email'];
            $user->title = $request['title'];
            //$user->role = $request['role'];
            $user->added_by_users_id = \Auth::user()->id;
            $user->save();

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
            // something went wrong
        }
    }

    public static function registration($request = null)
    {
        $person = Person::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
        ]);

        $company = Company::create([
            'name' => $request['name'],
            'abn' => $request['abn'],
            'website' => $request['website'],
        ]);

        $user = User::create([
            'user_name' => $request['user_name'],
            'password' => $request['password'],
            'person_id' => $person->id,
            'timezone' => 'sydney',
            'is_disabled' => '0',
            'is_active' => '1',
        ]);

        $agency = Agency::create([
            'company_id' => $company->id,

        ]);

        $agency_user = DB::table('agency_users')->insert([
            'agency_id' => $agency->id,
            'user_id' => $user->id,
            'level_id' => '4',
        ]);

        $phone = Phone::create([
            'number' => $request['number'],
            'type' => $request['type'],
            'area_code' => $request['area_code'],
            'country_code' => $request['country_code'],

        ]);

        $person_phone = DB::table('person_phones')->insert([
            'phone_id' => $phone->id,
            'person_id' => $person->id,
            'is_primary' => '1',
        ]);


        return array($person, $company, $user, $agency, $agency_user);
    }

    public static function index()
    {
        $users = DB::table('users')
            ->select('users.*', 'persons.*', 'phones.*', 'person_phones.*')
            ->leftJoin('persons', 'users.person_id', '=', 'persons.person_id')
            ->leftJoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->orderBy('users.user_id', 'desc')
            ->simplePaginate(15);


        return $users;
    }


}

