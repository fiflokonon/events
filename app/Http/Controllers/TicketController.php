<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManagerStatic as Image;
use ZipArchive;

#use Intervention\Image\Facades\Image;

class TicketController extends Controller
{
    public function processTickets(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'title' => 'required|unique:tickets|max:255',
            'quantity' => 'required|integer|min:1',
        ]);
        $title = $request->input('title');
        $quantity = $request->input('quantity');
        // Créez le dossier s'il n'existe pas encore
        $folderPath = storage_path("app/tickets/{$title}");
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
        // Créez les tickets en fonction du nombre spécifié
        for ($i = 0; $i < $quantity; $i++) {
            $ticket = Ticket::create([
                'title' => $title,
                'type' => 'lot',
                'payment_details' => null,
                'scanned' => false,
                'status' => true,
            ]);
            $this->generateQRCodeLink($ticket, $title, $i);
        }
        return redirect()->route('lot_tickets')->with('success', 'Les tickets ont été créés avec succès.');
    }

    private function generateQRCodeLink($ticket, $title, $number)
    {
        $key = $this->aesEncrypt($ticket->id);
        // Génération du lien QR avec simple-qrcode
        $qrCode = QrCode::format('png')->margin('5')->size(400)->generate($key);
        // Crée une image à partir du code QR
        $img = Image::make(base64_encode($qrCode));
        // Ajoute le titre et le numéro en bas de l'image
        $img->text("$title-000$number", $img->width() / 2, $img->height() - 10, function ($font) {
            $font->size(20);
            $font->color('#000000');
            $font->align('center');
        });

        // Sauvegarde l'image dans un fichier
        $filePath = "tickets/{$title}/{$title}-{$number}.png";
        Storage::put($filePath, $img->encode('png'));
        $ticket->key = $key;
        $ticket->link = $filePath;
        $ticket->save();
        #return $filePath;
    }

    public function lot_tickets()
    {
        $titlesWithCount = Ticket::select('title', DB::raw('count(*) as ticket_count'))
            ->where('type', 'lot')
            ->groupBy('title')
            ->get();

        return view('pages.list_tickets', [
            'lots' => $titlesWithCount
        ]);
    }

    public function downloadTickets($title)
    {
        $zipFileName = "{$title}_tickets.zip";
        $zipFilePath = storage_path("app/tickets/{$title}/{$zipFileName}");
        // Créez une instance de ZipArchive
        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // Ajoutez les fichiers du dossier au zip
            $files = Storage::allFiles("tickets/{$title}");
            foreach ($files as $file) {
                $relativePath = 'tickets/' . $title . '/' . basename($file);
                $zip->addFile(storage_path("app/{$relativePath}"), $relativePath);
            }
            // Fermez l'archive
            $zip->close();
        }
        // Retournez la réponse pour le téléchargement
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function getTicketInfo(Request $request)
    {
        $ticketId = $this->aesDecrypt($request->key);
        #dd($ticketId);
        if ($ticketId === null) {
           return response()->json(["success" => false, 'message' => 'Ticket non reconnu']);
        }

        // Récupère les informations du ticket
        $ticket = Ticket::find($ticketId);

        if (!$ticket) {
            // Ticket non trouvé
            abort(404); // Ou renvoyer une réponse appropriée
        }
        // Retourne les informations du ticket
        return response()->json(['success' => true, 'response' => $ticket]);
    }

    public function markTicketAsScanned($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if (!$ticket) {
            return response()->json(['success' => false, 'message' => 'Ticket non trouvé']);
        }
        if ($ticket->scanned) {
            return response()->json(['success' => false, 'message' => 'Le ticket a déjà été scanné.'], 400);
        }
        $ticket->update(['scanned' => true]);
        return response()->json(['success' => true, 'message' => 'Mise à jour réussie.'], 200);
    }
}
