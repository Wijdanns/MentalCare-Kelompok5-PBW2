<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UlasanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya user yang sudah login yang boleh menambah ulasan
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_psikolog' => [
                'required', 
                'exists:psikolog,id',
                // 1 user = 1 ulasan per psikolog
                Rule::unique('ulasan', 'id_psikolog')->where('id_user', Auth::id())
            ],
            'rating' => ['required', 'integer', 'between:1,5'],
            'komentar' => ['required', 'string', 'min:10', 'max:500'],
        ];
    }

    /**
     * Custom pesan error (opsional, agar berbahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'id_psikolog.required' => 'Pilih psikolog yang ingin kamu ulas.',
            'id_psikolog.exists' => 'Psikolog yang dipilih tidak ditemukan.',
            'id_psikolog.unique' => 'Kamu sudah memberi ulasan untuk psikolog ini.',
            'rating.required' => 'Pilih rating dari 1 sampai 5 bintang.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.between' => 'Rating harus antara 1 sampai 5.',
            'komentar.required' => 'Komentar wajib diisi.',
            'komentar.min' => 'Komentar minimal :min karakter.',
            'komentar.max' => 'Komentar maksimal :max karakter.',
        ];
    }
}