<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    
    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<string, mixed>
     */
    protected $fillable = [
        'name',
        'position',
        'photo',
        'order',
        'portfolio',
        'active'
    ];
    
    /**
     * Atribut yang harus dikonversi.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'portfolio' => 'array',
        'active' => 'boolean',
    ];
    
    /**
     * Mendapatkan anggota tim yang aktif.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActive()
    {
        return self::where('active', true)
                   ->orderBy('order', 'asc')
                   ->get();
    }
}