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

    private function generateQRCodeLink($ticket)
    {
        $key = $this->aesEncrypt($ticket->id);
        /*$displayText = "Votre texte personnalisé ici pour le ticket {$ticket->id}";
        $combinedData = "[{$key}]$-{$displayText}";*/
        $qrCode = QrCode::format('png')->size(400)->generate($key);
        $filePath = "tickets/0100-$ticket->id-$ticket->name.png";
        Storage::put($filePath, $qrCode);
        $ticket->key = $key;
        $ticket->link = $filePath;
        $ticket->save();
    }

    public function storeTicket(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'type_table' => 'required|string',
        ]);

        $ticket = new Ticket();
        $ticket->name = $validatedData['name'];
        $ticket->contact = $validatedData['contact'];
        $ticket->type_table = $validatedData['type_table'];
        $ticket->save();
        $this->generateQRCodeLink($ticket);
        return redirect()->route('list_tickets');
    }

    public function listTickets()
    {
        $tickets = Ticket::orderBy('id', 'desc')->get();
        return view('pages.list_tickets', compact('tickets'));
    }

    public function downloadTicket($ticketId)
    {
        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            abort(404);
        }
        $filePath = $ticket->link;
        $ticket->update(['downloaded' => true]);
        return response()->download(storage_path("app/{$filePath}"));
    }


    /*private function generateQRCodeLink($ticket, $title, $number)
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
    }*/

    public function getTicketInfo(Request $request)
    {
        $ticketId = $this->aesDecrypt($request->key);
        if ($ticketId === null) {
           return response()->json(["success" => false, 'message' => 'Ticket non reconnu']);
        }
        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            response()->json(['success' => true, 'message' => 'Ticket non trouvé']);
        }
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
