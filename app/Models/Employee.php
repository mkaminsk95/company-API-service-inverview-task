<?php

declare(strict_types=1);

namespace App\Models;

use App\Http\Helpers\PhoneHelper;
use Database\Factories\EmployeeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    /** @use HasFactory<EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'second_name',
        'email',
        'phone',
        'company_id',
    ];

    /**
     * @return BelongsTo<Company, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return Attribute<string, string>
     */
    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => PhoneHelper::cleanPhone($value),
        );
    }
}
