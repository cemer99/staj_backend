<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInstrumentControllerNew extends Controller
{
    /**
     * Display user's instruments
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $instruments = $user->userInstruments()->with('instrument')->get();

        return response()->json([
            'success' => true,
            'data' => $instruments
        ], 200, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ]);
    }

    /**
     * Store a new instrument for the user
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'instrument_id' => 'required|exists:instruments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422, [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]);
        }

        $user = $request->user();
        
        // Check if user already has this instrument
        $exists = $user->userInstruments()
            ->where('instrument_id', $request->instrument_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Bu enstrüman zaten profilinize eklenmiş.'
            ], 422, [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]);
        }

        $userInstrument = new UserInstrument();
        $userInstrument->user_id = $user->id;
        $userInstrument->instrument_id = $request->instrument_id;
        $userInstrument->save();

        return response()->json([
            'success' => true,
            'message' => 'Enstrüman başarıyla eklendi.',
            'data' => $userInstrument->load('instrument')
        ], 201, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ]);
    }

    /**
     * Update the user's instrument
     */
    public function update(Request $request)
    {
        // PHP'nin input stream'inden gelen raw veriye eriş (PUT istekleri için)
        $content = $request->getContent();
        \Illuminate\Support\Facades\Log::info('Raw Content:', ['content' => $content]);
        
        // Form-data veya JSON'dan gelen verileri işleme
        $data = $request->all();
        \Illuminate\Support\Facades\Log::info('Initial Request Data:', $data);
        
        // Eğer veri boş geliyorsa, muhtemelen form-data PUT isteği
        if (empty($data) && !empty($content)) {
            // Raw input'tan gelen veriyi parse et
            parse_str($content, $parsedData);
            \Illuminate\Support\Facades\Log::info('Parsed Raw Data:', $parsedData);
            
            // Parse edilmiş veriyi request'e ekle
            if (!empty($parsedData)) {
                $request->merge($parsedData);
                $data = $request->all();
            }
        }
        
        // İD'yi doğru şekilde işle
        if (isset($data['id'])) {
            $id = $data['id'];
            // Array ise ilk elemanı al
            if (is_array($id)) {
                $id = $id[0];
            }
            $request->merge(['id' => (int)$id]);
        }
        
        \Illuminate\Support\Facades\Log::info('Final Request Data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:user_instruments,id',
            'instrument_id' => 'nullable|exists:instruments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422, [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]);
        }

        $user = $request->user();
        
        $userInstrument = UserInstrument::where('id', $request->id)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$userInstrument) {
            return response()->json([
                'success' => false,
                'message' => 'Enstrüman bulunamadı veya bu enstrüman size ait değil.'
            ], 404, [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]);
        }

        // Sadece instrument_id alanını güncelle
        if ($request->has('instrument_id')) {
            // Seçilen enstrümanın kullanıcıya ait olup olmadığını kontrol et
            $exists = UserInstrument::where('user_id', $user->id)
                ->where('instrument_id', $request->instrument_id)
                ->where('id', '!=', $userInstrument->id) // Kendisi hariç
                ->exists();
            
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu enstrüman zaten profilinize eklenmiş.'
                ], 422, [
                    'Content-Type' => 'application/json; charset=UTF-8'
                ]);
            }
            
            $userInstrument->instrument_id = $request->instrument_id;
        }
        
        $userInstrument->save();

        return response()->json([
            'success' => true,
            'message' => 'Enstrüman bilgileri güncellendi.',
            'data' => $userInstrument->load('instrument')
        ], 200, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ]);
    }

    /**
     * Remove the user's instrument
     */
    public function destroy(Request $request)
    {
        // PHP'nin input stream'inden gelen raw veriye eriş (DELETE istekleri için)
        $content = $request->getContent();
        \Illuminate\Support\Facades\Log::info('Raw Content Delete:', ['content' => $content]);
        
        // Form-data veya JSON'dan gelen verileri işleme
        $data = $request->all();
        \Illuminate\Support\Facades\Log::info('Initial Delete Request Data:', $data);
        
        // Eğer veri boş geliyorsa, muhtemelen form-data DELETE isteği
        if (empty($data) && !empty($content)) {
            // Raw input'tan gelen veriyi parse et
            parse_str($content, $parsedData);
            \Illuminate\Support\Facades\Log::info('Parsed Raw Delete Data:', $parsedData);
            
            // Parse edilmiş veriyi request'e ekle
            if (!empty($parsedData)) {
                $request->merge($parsedData);
                $data = $request->all();
            }
        }
        
        // İD'yi doğru şekilde işle
        if (isset($data['id'])) {
            $id = $data['id'];
            // Array ise ilk elemanı al
            if (is_array($id)) {
                $id = $id[0];
            }
            $request->merge(['id' => (int)$id]);
        }
        
        \Illuminate\Support\Facades\Log::info('Final Delete Request Data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:user_instruments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422, [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]);
        }

        $user = $request->user();
        
        $userInstrument = UserInstrument::where('id', $request->id)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$userInstrument) {
            return response()->json([
                'success' => false,
                'message' => 'Enstrüman bulunamadı veya bu enstrüman size ait değil.'
            ], 404, [
                'Content-Type' => 'application/json; charset=UTF-8'
            ]);
        }

        $userInstrument->delete();

        return response()->json([
            'success' => true,
            'message' => 'Enstrüman başarıyla kaldırıldı.'
        ], 200, [
            'Content-Type' => 'application/json; charset=UTF-8'
        ]);
    }
}
