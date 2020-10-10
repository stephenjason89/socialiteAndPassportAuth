<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Social_account
 *
 * @property int $id
 * @property string $provider_id
 * @property string $provider_name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereProviderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Social_account whereUserId($value)
 * @mixin \Eloquent
 */
class Social_account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'provider_name',
        'provider_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
