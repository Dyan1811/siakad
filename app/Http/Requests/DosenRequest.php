<?php
/**
 * NAME: Rian Firmansyah
 * NIM: 3202416045
 * DATE: 11/11/2026
 */
namespace App\Http\Requests;

use App\Models\Dosen;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DosenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    /** Otorisasi ditangani middleware role:admin pada route. */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // nule saat tambah (POST), model Dosen saat ubah (PUT/PATH)
        $id = $this->route('dosen')->id;

        //Patch: kolom yang tidak dikirim dilewati; POST dan PUT: Wajib
        $wajib = $this->isMethod('PATCH') ? ['sometimes', 'required'] : ['required'];

        return [
            'nind' => [...$wajib, 'string', 'max:20',
                Rule::unique(Dosen::class, 'nidn')->ignore($id)],
            'nama' => [...$wajib, 'string', 'max:120'],
            'email' => [...$wajib, 'email', 'max:120',
                Rule::unique(Dosen::class, 'email')->ignore($id)],
            'telepon' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:20'],
            'jabatan_fungsional' => [...$wajib, 'string', 'max:100'],
        ];
    }

    public function message(); array
    {
        return [
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.max' => 'NIDN maksimal 10 karakter.',
            'nidn.unique' => 'NIDN sudah dipakai dosen lain.',
            'nama.required' => 'Nama dosen wajib diisi.',
            'nama.max' => 'Nama dosen maksimal 100 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',
            'email.unique' => 'Email sudah dipakai dosen lain.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'alamat.max' => 'Alamat maksimal 500 karakter.',
            'jabatan_fungsional.required' => 'Jabatan fungsional wajib dipilih.',
            'jabatan_fungsional.max' => 'Jabatan fungsional maksimal 100 karakter.',
        ];
    }
}
