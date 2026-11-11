<?php
/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 11/11/2026
 */
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DosenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /** Bentuk JSON satu dosen. Hanya kolom di sini yang dikirim ke klien. */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nidn' => $this->nidn,
            'nama' => $this->nama,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
            'jabatan' =>$this->jabatan_fungsional,
            'dibuat_pada' => $this->create_at?->toIso8601String(),
            'diperbarui_pada' => $this->updated_at?->toIso8601String(),
        ];
    }
}
