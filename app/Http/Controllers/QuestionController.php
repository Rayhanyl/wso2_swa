<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{

    public function questionPage(){

        $faqs = json_decode(Storage::get('faqs.json'))->list;
        return view('question.index', compact('faqs'));

        // $jsonData = file_get_contents(public_path('json/about.json'));
        // $data = json_decode($jsonData);
        // return view('question.index', compact('data'));
    }
}

// {
//     private $json_file = 'faqs.json';
    
//     public function index()
//     {
//         $faqs = json_decode(Storage::get($this->json_file));
//         return view('faqs.index', compact('faqs'));
//     }

//     public function create()
//     {
//         return view('faqs.create');
//     }

//     public function store(Request $request)
//     {
//         $faqs = json_decode(Storage::get($this->json_file), true);
//         $faq = [
//             'id' => count($faqs) + 1,
//             'order' => $request->order,
//             'order_flush' => $request->order_flush,
//             'question' => $request->question,
//             'answere' => null,
//             'created_at' => date('d-m-Y')
//         ];
//         $faqs[] = $faq;
//         Storage::put($this->json_file, json_encode($faqs));
//         return redirect()->route('faqs.index');
//     }

//     public function edit($id)
//     {
//         $faqs = json_decode(Storage::get($this->json_file), true);
//         $faq = $faqs[$id - 1];
//         return view('faqs.edit', compact('faq'));
//     }

//     public function update(Request $request, $id)
//     {
//         $faqs = json_decode(Storage::get($this->json_file), true);
//         $faqs[$id - 1]['order'] = $request->order;
//         $faqs[$id - 1]['order_flush'] = $request->order_flush;
//         $faqs[$id - 1]['question'] = $request->question;
//         Storage::put($this->json_file, json_encode($faqs));
//         return redirect()->route('faqs.index');
//     }

//     public function destroy($id)
//     {
//         $faqs = json_decode(Storage::get($this->json_file), true);
//         unset($faqs[$id - 1]);
//         Storage::put($this->json_file, json_encode(array_values($faqs)));
//         return redirect()->route('faqs.index');
//     }
// }

// Route::get('/', [FaqController::class, 'index'])->name('faqs.index');
// Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
// Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
// Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
// Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
