<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;

class AdminCertificateController extends Controller
{
    // Menampilkan daftar certificate
    public function index()
    {
        $certificates = Certificate::all();
        return view('admin.certificate.index', compact('certificates'));
    }

    // Show form to create a new certificate
    public function create()
    {
        return view('admin.certificate.create');
    }

    // Store a new certificate
    public function store(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issued_by' => 'required|string|max:255',
            'issued_at' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file yang diupload
            'description' => 'nullable|string|max:1000',
        ]);

        // If a file is uploaded, store it
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('certificates', 'public');
        }

        // Create a new certificate in the database
        Certificate::create($validated);

        // Redirect with success message
        return redirect()->route('admin.certificate.index')->with('success', 'Certificate created successfully!');
    }

    // Show form to edit an existing certificate
    public function edit($id)
    {
        $certif = Certificate::findOrFail($id);
        return view('admin.certificate.certifedit', compact('certif'));
    }

    // Update an existing certificate
    public function update(Request $request, Certificate $certificate)
    {
        // Validate the input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issued_by' => 'required|string|max:255',
            'issued_at' => 'required|date',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:2048', // Validasi file yang diupload
            'description' => 'nullable|string|max:1000',
        ]);

        // If a new file is uploaded, store it
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($certificate->file) {
                Storage::delete($certificate->file);
            }
            $validated['file'] = $request->file('file')->store('certificates', 'public');
        }

        // Update the certificate data
        $certificate->update($validated);

        // Redirect with success message
        return redirect()->route('admin.certificate.index')->with('success', 'Certificate updated successfully!');
    }

    // Delete an existing certificate
    public function destroy(Certificate $certificate)
    {
        // Hapus file terkait dengan sertifikat jika ada
        if ($certificate->file) {
            Storage::delete($certificate->file);
        }

        // Delete the certificate from the database
        $certificate->delete();

        // Redirect with success message
        return redirect()->route('admin.certificate.index')->with('success', 'Certificate deleted successfully!');
    }
}
