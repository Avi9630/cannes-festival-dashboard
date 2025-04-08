<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\IpApplicationFormController;

class IpPdfCommand extends Command
{
    protected $signature = 'app:ip-pdf-command';
    protected $description = 'Generate a PDF using the specified controller function for IP';
    public function handle()
    {
        try {
            $controller = new IpApplicationFormController();
            $controller->pdfGenerator();
            $this->info('PDF generated successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error generating PDF: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
