<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DriverBan extends Model
{
    use HasFactory;

    const BAN_REASONS = [
        'violation_terms' => 'Violation of Terms and Conditions',
        'poor_behavior' => 'Poor Behavior with Passengers',
        'fraud' => 'Fraudulent Activity',
        'multiple_complaints' => 'Multiple Customer Complaints',
        'safety_issues' => 'Safety Violations',
        'document_fraud' => 'Fraudulent Documents',
        'license_expired' => 'Expired License',
        'vehicle_issues' => 'Vehicle Safety Issues',
        'unprofessional_conduct' => 'Unprofessional Conduct',
        'other' => 'Other',
    ];

    protected $fillable = [
        'driver_id',
        'admin_id',
        'ban_reason',
        'ban_description',
        'banned_at',
        'ban_until',
        'is_permanent',
        'is_active',
        'unbanned_at',
        'unbanned_by',
        'unban_reason',
    ];

    protected $casts = [
        'banned_at' => 'datetime',
        'ban_until' => 'datetime',
        'unbanned_at' => 'datetime',
        'is_permanent' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function unbannedByAdmin()
    {
        return $this->belongsTo(Admin::class, 'unbanned_by');
    }

    /**
     * Check if ban is expired
     */
    public function isExpired()
    {
        if ($this->is_permanent) {
            return false;
        }

        if ($this->ban_until && Carbon::now()->greaterThan($this->ban_until)) {
            return true;
        }

        return false;
    }

    /**
     * Get ban status text
     */
    public function getStatusText()
    {
        if (!$this->is_active) {
            return 'Lifted';
        }

        if ($this->is_permanent) {
            return 'Permanent';
        }

        if ($this->isExpired()) {
            return 'Expired';
        }

        return 'Active';
    }

    /**
     * Get ban reason text
     */
    public function getReasonText()
    {
        return self::BAN_REASONS[$this->ban_reason] ?? $this->ban_reason;
    }

    /**
     * Get remaining ban time
     */
    public function getRemainingTime()
    {
        if ($this->is_permanent) {
            return 'Permanent';
        }

        if (!$this->ban_until) {
            return 'N/A';
        }

        if ($this->isExpired()) {
            return 'Expired';
        }

        return Carbon::now()->diffForHumans($this->ban_until, true);
    }

    /**
     * Scope for active bans
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for permanent bans
     */
    public function scopePermanent($query)
    {
        return $query->where('is_permanent', true);
    }

    /**
     * Scope for temporary bans
     */
    public function scopeTemporary($query)
    {
        return $query->where('is_permanent', false);
    }
}