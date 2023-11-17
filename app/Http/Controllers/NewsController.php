<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{

    # Mendapatkan semua data News
    public function index()
	{
        # menggunakan model News untuk select data
		$news = News::all();

		if (!empty($news)) {
			$response = [
				'message' => 'Menampilkan Data Semua Student',
				'data' => $news,
			];
			return response()->json($response, 200);
		} else {
			$response = [
				'message' => 'Data tidak ada'
			];
			return response()->json($response, 404);
		}
	}

    # Store untuk menyimpan data baru
    public function store(Request $request)
    {
        # Validasi data yang diterima dari request
        $validateData = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'description' => 'required',
            'content' => 'required',
            'url' => 'required',
            'url_image' => 'required',
            'published_at' => 'required|date',
            'category' => 'required',
        ]);

        # Membuat instansiasi model News dan menyimpan data baru
        $news = News::create($validateData);

        $data = [
            'message' => 'Berita berhasil disimpan',
            'data' => $news,
        ];

        return response()->json($data, 201);
    }

    # Menampilkan detail berita berdasarkan ID
    public function show($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Mendapatkan detail berita', 'data' => $news], 200);
    }

    # Memperbarui data berita berdasarkan ID
    public function update(Request $request, $id)
    {
        $news = News::find($id);

        if ($news) {
            # Memperbarui berita dengan data yang baru dari request
            $news->update($request->all());

            $response = [
                'message' => 'Berita berhasil diperbarui',
                'data' => $news,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Berita tidak ditemukan',
            ];

            return response()->json($response, 404);
        }
    }

    # Menghapus berita berdasarkan ID
    public function destroy($id)
    {
        $news = News::find($id);

        if ($news) {
            $news->delete();

            $response = [
                'message' => 'Berita berhasil dihapus',
                'data' => $news,
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Berita tidak ditemukan',
            ];

            return response()->json($response, 404);
        }
    }

     # fitur mencari berdasarkan yang ingin kita cari
    public function search($query)
    {
        # Melakukan pencarian berita berdasarkan judul, konten, atau kategori yang cocok dengan query
        $news = News::where('title', 'like', '%' . $query . '%')
        ->orWhere('author', 'like', '%' . $query . '%')
        ->orWhere('category', '=', $query)
        ->get();

        if ($news->count()) {
            $resource = [
                'message' => 'Hasil pencarian: ',
                'data' => $news,
            ];
            return response()->json($resource, 200);
        } else {
            $data = [
                'message' => 'Tidak ada hasil pencarian',
            ];

            return response()->json($data, 404);
        }

    }


    # Mengambil data berita dengan kategori "sport"
    public function sport()
    {
        $sportNews = News::where('category', 'sport')->get();

        return response()->json(['message' => 'Get resource berita olahraga', 'total' => count($sportNews), 'data' => $sportNews], 200);
    }

    # Mengambil data berita dengan kategori "finance"
    public function finance()
    {
        $financeNews = News::where('category', 'finance')->get();

        return response()->json(['message' => 'Get resource berita finansial', 'total' => count($financeNews), 'data' => $financeNews], 200);
    }

    # Mengambil data berita dengan kategori "automotive"
    public function automotive()
    {
        $automotiveNews = News::where('category', 'automotive')->get();

        return response()->json(['message' => 'Get resource berita otomotif', 'total' => count($automotiveNews), 'data' => $automotiveNews], 200);
    }
}
