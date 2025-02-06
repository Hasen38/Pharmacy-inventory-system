<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use Filament\Resources\Pages\Page;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateInvoice extends Page
{
    public $sale;

    protected static string $resource = SaleResource::class;

    protected static string $view = 'filament.resources.sale-resource.pages.generate-invoice';

    public function mount($record)
    {
        $this->sale = $this->getResource()::getModel()::findOrFail($record);

        $pdf = Pdf::loadView('pdf.invoice', [
            'sale' => $this->sale,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "invoice-{$this->sale->id}.pdf");
    }
}
