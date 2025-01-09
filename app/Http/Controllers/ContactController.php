<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    /**
     * Affiche la page de contact.
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Traite l'envoi du formulaire de contact.
     */
    public function send(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Envoi de l'e-mail
        Mail::to($request->email)->send(new ContactFormMail($request->all()));

        // Redirection avec un message de succès
        return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès !');
    }
}