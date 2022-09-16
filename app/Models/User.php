<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'sexo',
        'tipo'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function startups()
    {
        return $this->hasMany(Startup::class);
    }

    public function investidor()
    {
        return $this->hasOne(Investidor::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

    /*
     * Array profile enum
    */
    public const PROFILE_ENUM = [
        'entrepreneur' => 1,
        'investor' => 2,
    ];

    public const SEXO_ENUM = [
        'feminine' => 1,
        'masculine' => 2,
        'prefer_not_to_inform' => 3,
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($user) {
            $investidor = new Investidor();
            $investidor->user()->associate($user);
            $investidor->carteira = 500000;
            $investidor->save();
        });
    }

    /**
     * Save profile photo in the path
     *
     * @param Array $input : input with profile photo
     *
     * @return void
     */
    public function save_profile_foto($input) {
        if (array_key_exists('photo', $input)) {
            if ($this->profile_photo_path != null) {
                if (Storage::disk()->exists('public/' . $this->profile_photo_path)) {
                    Storage::delete('public/' . $this->profile_photo_path);
                }
            }

            $path = 'users/'.$this->id.'/';
            $photo_name = $input['photo']->getClientOriginalName();
            Storage::putFileAs('public/'.$path, $input['photo'], $photo_name);
            $this->profile_photo_path = $path . $photo_name;
            $this->update();
        }

        $this->save();
    }

    /**
     * Set atributes user object
     *
     * @param Array $input : input with atributes user
     *
     * @return void
     */
    public function set_attributes($input) {
        $this->name = $input['nome'];
        $this->email = $input['email'];
        $this->password = Hash::make($input['password']);
        $this->tipo = $input['profile'];
        $this->cpf = $input['cpf'];
        $this->data_de_nascimento = $input['data_de_nascimento'];
        $this->sexo = $input['sexo'];
    }
}
