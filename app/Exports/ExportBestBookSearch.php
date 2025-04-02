<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Editor;
use App\Models\Book;

class ExportBestBookSearch implements FromCollection, WithHeadings, WithMapping  //FromView
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $searchData = $this->data;
        return $searchData;
    }

    public function map($bestBookCinema): array
    {
        $client =   Client::find($bestBookCinema->client_id);
        if (!is_null($client)) {
            $clientName = $client->first_name . ' ' . $client->last_name;
            $clientEmail = $client->email;
        } else {
            $clientName = '';
            $clientEmail = '';
        }

        //  Best Book
        $books = Book::where(['best_book_cinemas_id' => $bestBookCinema->id, 'client_id' => $bestBookCinema->client_id])->get();

        foreach ($books as $key => $book) {

            if ($key == 0) {
                $Book1bookTitleOriginal      =   $book->book_title_original;
                $Book1bookTitleEnglish       =   $book->book_title_english;
                $Book1englishTranslationBook =   $book->english_translation_book;
                $Book1language               =   $book->language;
                $Book1authorName             =   $book->author_name;
                $Book1pageCount              =   $book->page_count;
                $Book1dateOfPublication      =   $book->date_of_publication;
                $Book1bookPrice              =   $book->book_price;
            }

            if ($key == 1) {
                $Book2bookTitleOriginal      =   $book->book_title_original;
                $Book2bookTitleEnglish       =   $book->book_title_english;
                $Book2englishTranslationBook =   $book->english_translation_book;
                $Book2language               =   $book->language;
                $Book2authorName             =   $book->author_name;
                $Book2pageCount              =   $book->page_count;
                $Book2dateOfPublication      =   $book->date_of_publication;
                $Book2bookPrice              =   $book->book_price;
            }

            if ($key == 2) {
                $Book3bookTitleOriginal      =   $book->book_title_original;
                $Book3bookTitleEnglish       =   $book->book_title_english;
                $Book3englishTranslationBook =   $book->english_translation_book;
                $Book3language               =   $book->language;
                $Book3authorName             =   $book->author_name;
                $Book3pageCount              =   $book->page_count;
                $Book3dateOfPublication      =   $book->date_of_publication;
                $Book3bookPrice              =   $book->book_price;
            }

            if ($key == 3) {
                $Book4bookTitleOriginal      =   $book->book_title_original;
                $Book4bookTitleEnglish       =   $book->book_title_english;
                $Book4englishTranslationBook =   $book->english_translation_book;
                $Book4language               =   $book->language;
                $Book4authorName             =   $book->author_name;
                $Book4pageCount              =   $book->page_count;
                $Book4dateOfPublication      =   $book->date_of_publication;
                $Book4bookPrice              =   $book->book_price;
            }

            if ($key == 4) {
                $Book5bookTitleOriginal      =   $book->book_title_original;
                $Book5bookTitleEnglish       =   $book->book_title_english;
                $Book5englishTranslationBook =   $book->english_translation_book;
                $Book5language               =   $book->language;
                $Book5authorName             =   $book->author_name;
                $Book5pageCount              =   $book->page_count;
                $Book5dateOfPublication      =   $book->date_of_publication;
                $Book5bookPrice              =   $book->book_price;
            }
        }

        //  Editors
        $editors = Editor::where(['best_book_cinema_id' => $bestBookCinema->id, 'client_id' => $bestBookCinema->client_id])->get();

        foreach ($editors as $key => $editor) {

            if ($key == 0) {
                $Editor1editorName         =   $editor->name;
                $Editor1editorEmail        =   $editor->editor_email;
                $Editor1editorMobile       =   $editor->editor_mobile;
                $Editor1editorLandline     =   $editor->editor_landline;
                $Editor1editorAddress      =   $editor->editor_address;
                $Editor1editorCitizenship  =   isset($editor->editor_citizenship) && $editor->editor_citizenship == 1 ? 'Indian' : NULL;
            }

            if ($key == 1) {
                $Editor2editorName         =   $editor->name;
                $Editor2editorEmail        =   $editor->editor_email;
                $Editor2editorMobile       =   $editor->editor_mobile;
                $Editor2editorLandline     =   $editor->editor_landline;
                $Editor2editorAddress      =   $editor->editor_address;
                $Editor2editorCitizenship  =   isset($editor->editor_citizenship) && $editor->editor_citizenship == 1 ? 'Indian' : NULL;
            }

            if ($key == 2) {
                $Editor3editorName         =   $editor->name;
                $Editor3editorEmail        =   $editor->editor_email;
                $Editor3editorMobile       =   $editor->editor_mobile;
                $Editor3editorLandline     =   $editor->editor_landline;
                $Editor3editorAddress      =   $editor->editor_address;
                $Editor3editorCitizenship  =   isset($editor->editor_citizenship) && $editor->editor_citizenship == 1 ? 'Indian' : NULL;
            }

            if ($key == 3) {
                $Editor4editorName         =   $editor->name;
                $Editor4editorEmail        =   $editor->editor_email;
                $Editor4editorMobile       =   $editor->editor_mobile;
                $Editor4editorLandline     =   $editor->editor_landline;
                $Editor4editorAddress      =   $editor->editor_address;
                $Editor4editorCitizenship  =   isset($editor->editor_citizenship) && $editor->editor_citizenship == 1 ? 'Indian' : NULL;
            }

            if ($key == 4) {
                $Editor5editorName         =   $editor->name;
                $Editor5editorEmail        =   $editor->editor_email;
                $Editor5editorMobile       =   $editor->editor_mobile;
                $Editor5editorLandline     =   $editor->editor_landline;
                $Editor5editorAddress      =   $editor->editor_address;
                $Editor5editorCitizenship  =   isset($editor->editor_citizenship) && $editor->editor_citizenship == 1 ? 'Indian' : NULL;
            }
        }

        $payment   =   Transaction::where([
            'website_type'  =>  1,
            'client_id'     =>  $bestBookCinema['client_id'],
            'context_id'    =>  $bestBookCinema['id'],
            'auth_status'   =>  '0300',
        ])->first();

        if (!is_null($payment)) {
            $paymentDate    =   $payment->payment_date;
            $paymentAmount  =   $payment->amount;
            $paymentReceipt =   $payment->bank_ref_no;
        } else {
            $paymentDate    =   '';
            $paymentAmount  =   '';
            $paymentReceipt =   '';
        }

        $data =  [

            //Client Details
            $bestBookCinema->id,
            $clientName,
            $clientEmail,

            //Step:- 1 Best Book On Cinema
            isset($Book1bookTitleOriginal) ? $Book1bookTitleOriginal : '',
            isset($Book1bookTitleEnglish) ? $Book1bookTitleEnglish : '',
            isset($Book1englishTranslationBook) ? $Book1englishTranslationBook : '',
            isset($Book1language) ? $Book1language : '',
            isset($Book1authorName) ? $Book1authorName : '',
            isset($Book1pageCount) ? $Book1pageCount : '',
            isset($Book1dateOfPublication) ? $Book1dateOfPublication : '',
            isset($Book1bookPrice) ? $Book1bookPrice : '',

            isset($Book2bookTitleOriginal) ? $Book2bookTitleOriginal : '',
            isset($Book2bookTitleEnglish) ? $Book2bookTitleEnglish : '',
            isset($Book2englishTranslationBook) ? $Book2englishTranslationBook : '',
            isset($Book2language) ? $Book2language : '',
            isset($Book2authorName) ? $Book2authorName : '',
            isset($Book2pageCount) ? $Book2pageCount : '',
            isset($Book2dateOfPublication) ? $Book2dateOfPublication : '',
            isset($Book2bookPrice) ? $Book2bookPrice : '',

            isset($Book3bookTitleOriginal) ? $Book3bookTitleOriginal : '',
            isset($Book3bookTitleEnglish) ? $Book3bookTitleEnglish : '',
            isset($Book3englishTranslationBook) ? $Book3englishTranslationBook : '',
            isset($Book3language) ? $Book3language : '',
            isset($Book3authorName) ? $Book3authorName : '',
            isset($Book3pageCount) ? $Book3pageCount : '',
            isset($Book3dateOfPublication) ? $Book3dateOfPublication : '',
            isset($Book3bookPrice) ? $Book3bookPrice : '',

            isset($Book4bookTitleOriginal) ? $Book4bookTitleOriginal : '',
            isset($Book4bookTitleEnglish) ? $Book4bookTitleEnglish : '',
            isset($Book4englishTranslationBook) ? $Book4englishTranslationBook : '',
            isset($Book4language) ? $Book4language : '',
            isset($Book4authorName) ? $Book4authorName : '',
            isset($Book4pageCount) ? $Book4pageCount : '',
            isset($Book4dateOfPublication) ? $Book4dateOfPublication : '',
            isset($Book4bookPrice) ? $Book4bookPrice : '',

            isset($Book5bookTitleOriginal) ? $Book5bookTitleOriginal : '',
            isset($Book5bookTitleEnglish) ? $Book5bookTitleEnglish : '',
            isset($Book5englishTranslationBook) ? $Book5englishTranslationBook : '',
            isset($Book5language) ? $Book5language : '',
            isset($Book5authorName) ? $Book5authorName : '',
            isset($Book5pageCount) ? $Book5pageCount : '',
            isset($Book5dateOfPublication) ? $Book5dateOfPublication : '',
            isset($Book5bookPrice) ? $Book5bookPrice : '',

            //Step: 2 Author & Payment Details
            $bestBookCinema->author_name ?? '',
            $bestBookCinema->author_address ?? '',
            $bestBookCinema->author_contact ?? '',
            $bestBookCinema->author_nationality_indian === 1 ? 'Indian' : NULL,
            // $bestBookCinema->author_profile,

            //Step:- 3 Editors
            isset($Editor1editorName) ? $Editor1editorName : '',
            isset($Editor1editorEmail) ? $Editor1editorEmail : '',
            isset($Editor1editorMobile) ? $Editor1editorMobile : '',
            isset($Editor1editorLandline) ? $Editor1editorLandline : '',
            isset($Editor1editorAddress) ? $Editor1editorAddress : '',
            isset($Editor1editorCitizenship) ? $Editor1editorCitizenship : '',

            isset($Editor2editorName) ? $Editor2editorName : '',
            isset($Editor2editorEmail) ? $Editor2editorEmail : '',
            isset($Editor2editorMobile) ? $Editor2editorMobile : '',
            isset($Editor2editorLandline) ? $Editor2editorLandline : '',
            isset($Editor2editorAddress) ? $Editor2editorAddress : '',
            isset($Editor2editorCitizenship) ? $Editor2editorCitizenship : '',

            isset($Editor3editorName) ? $Editor3editorName : '',
            isset($Editor3editorEmail) ? $Editor3editorEmail : '',
            isset($Editor3editorMobile) ? $Editor3editorMobile : '',
            isset($Editor3editorLandline) ? $Editor3editorLandline : '',
            isset($Editor3editorAddress) ? $Editor3editorAddress : '',
            isset($Editor3editorCitizenship) ? $Editor3editorCitizenship : '',

            isset($Editor4editorName) ? $Editor4editorName : '',
            isset($Editor4editorEmail) ? $Editor4editorEmail : '',
            isset($Editor4editorMobile) ? $Editor4editorMobile : '',
            isset($Editor4editorLandline) ? $Editor4editorLandline : '',
            isset($Editor4editorAddress) ? $Editor4editorAddress : '',
            isset($Editor4editorCitizenship) ? $Editor4editorCitizenship : '',

            isset($Editor5editorName) ? $Editor5editorName : '',
            isset($Editor5editorEmail) ? $Editor5editorEmail : '',
            isset($Editor5editorMobile) ? $Editor5editorMobile : '',
            isset($Editor5editorLandline) ? $Editor5editorLandline : '',
            isset($Editor5editorAddress) ? $Editor5editorAddress : '',
            isset($Editor5editorCitizenship) ? $Editor5editorCitizenship : '',

            //PAYMENT
            $paymentDate,
            $paymentAmount,
            $paymentReceipt,
        ];
        return $data;
    }

    public function headings(): array
    {
        return [

            //Client Details
            'Movie Ref',
            'Client Name',
            'Client Email',

            //Step:- 1 Best Book On Cinema
            'Book 1 Title of the book (Original Language)',
            'Book 1 Title of the book (English Language)',
            'Book 1 English translation of the book title',
            'Book 1 language',
            'Book 1 Author name',
            'Book 1 No of pages',
            'Book 1 Date of publication',
            'Book 1 price',

            'Book 2 Title of the book (Original Language)',
            'Book 2 Title of the book (English Language)',
            'Book 2 English translation of the book title',
            'Book 2 language',
            'Book 2 Author name',
            'Book 2 No of pages',
            'Book 2 Date of publication',
            'Book 2 price',

            'Book 3 Title of the book (Original Language)',
            'Book 3 Title of the book (English Language)',
            'Book 3 English translation of the book title',
            'Book 3 language',
            'Book 3 Author name',
            'Book 3 No of pages',
            'Book 3 Date of publication',
            'Book 3 price',

            'Book 4 Title of the book (Original Language)',
            'Book 4 Title of the book (English Language)',
            'Book 4 English translation of the book title',
            'Book 4 language',
            'Book 4 Author name',
            'Book 4 No of pages',
            'Book 4 Date of publication',
            'Book 4 price',

            'Book 5 Title of the book (Original Language)',
            'Book 5 Title of the book (English Language)',
            'Book 5 English translation of the book title',
            'Book 5 language',
            'Book 5 Author name',
            'Book 5 No of pages',
            'Book 5 Date of publication',
            'Book 5 price',

            //Step:- 2 Author & Payment Details
            'Author name',
            'Author address',
            'Author contact No',
            'Author indian nationality',
            // 'Author profile',

            //Step:- 3 Publisher Of the Book / Editor(s) Of The Newspapper 
            'Editor 1 Editor Name',
            'Editor 1 Email ID',
            'Editor 1 Landline No',
            'Editor 1 Mobile No',
            'Editor 1 Address',
            'Editor 1 Citizenship',

            'Editor 2 Editor Name',
            'Editor 2 Email ID',
            'Editor 2 Landline No',
            'Editor 2 Mobile No',
            'Editor 2 Address',
            'Editor 2 Citizenship',

            'Editor 3 Editor Name',
            'Editor 3 Email ID',
            'Editor 3 Landline No',
            'Editor 3 Mobile No',
            'Editor 3 Address',
            'Editor 3 Citizenship',

            'Editor 4 Editor Name',
            'Editor 4 Email ID',
            'Editor 4 Landline No',
            'Editor 4 Mobile No',
            'Editor 4 Address',
            'Editor 4 Citizenship',

            'Editor 5 Editor Name',
            'Editor 5 Email ID',
            'Editor 5 Landline No',
            'Editor 5 Mobile No',
            'Editor 5 Address',
            'Editor 5 Citizenship',

            //PAYMENT
            'Payment Date & Time',
            'Payment Amount',
            'Payment Receipt No',
        ];
    }
}
