<?php

namespace App\Jobs;

use App\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class RetrieveBookContentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Book $book
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // @TODO implement

        $apiResponse = Http::get("https://rak-buku-api.vercel.app/api/books/{$this->book->isbn}");

        $bookContents = [];
        if ($apiResponse->successful()) {
            $contents = $apiResponse->json()['data']['details']['table_of_contents'] ?? [];
            foreach ($contents as $content) {
                $bookContents[] = [
                    'label' => $content['label'] ?? null,
                    'title' => $content['title'],
                    'page_number' => $content['pagenum'],
                ];
            }
        } elseif ($apiResponse->status() === 404) {
            $bookContents[] = [
                'label' => null,
                'title' => 'Cover',
                'page_number' => 1,
            ];
        }

        $book = Book::find($this->book->id);

        foreach ($bookContents as $content) {
            $book->bookContents()->create($content);
        }

    }
}
